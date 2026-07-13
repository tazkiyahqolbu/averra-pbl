<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PengembalianBarang;
use App\Models\Pemesanan;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Mail\PembayaranBerhasilMail;
use Illuminate\Support\Facades\Mail;

class PembayaranController extends Controller
{
    public function __construct(private MidtransService $midtrans) {}

    public function pilih(int $id): View|RedirectResponse
    {
        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->with('pembayarans')
            ->findOrFail($id);

        $allowedStatuses = ['dikonfirmasi', 'berlangsung', 'menunggu_dp', 'menunggu_pelunasan'];

        if (!in_array($pesanan->status, $allowedStatuses)) {
            return redirect()->route('user.pemesanan.show', $id)
                ->with('error', 'Pesanan belum dikonfirmasi oleh admin.');
        }

        $sudahBayar = $pesanan->totalDibayar();

        if ($sudahBayar >= $pesanan->total_harga && $pesanan->status !== 'menunggu_pelunasan') {
            return redirect()->route('user.pemesanan.show', $id)
                ->with('error', 'Pesanan ini sudah lunas.');
        }

        $isPelunasan = $pesanan->pembayarans
            ->where('tahap', 'dp')
            ->where('status', 'terverifikasi')
            ->isNotEmpty();

        return view('user.pemesanan.pilih-pembayaran', compact('pesanan', 'isPelunasan'));
    }

    public function initiate(Request $request, int $id): View|RedirectResponse
    {
        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->with(['pembayarans', 'user', 'detailPemesanans'])
            ->findOrFail($id);

        $allowedStatuses = ['dikonfirmasi', 'berlangsung', 'menunggu_dp', 'menunggu_pelunasan'];

        if (!in_array($pesanan->status, $allowedStatuses)) {
            return back()->with('error', 'Pesanan belum dikonfirmasi.');
        }

        $isPelunasan = $pesanan->pembayarans
            ->where('tahap', 'dp')
            ->where('status', 'terverifikasi')
            ->isNotEmpty();

        if ($isPelunasan || $pesanan->isMenungguPelunasan()) {
            $sudahBayar  = $pesanan->pembayarans->where('status', 'terverifikasi')->sum('jumlah_bayar');
            $sisaSewa    = max(0, (float) $pesanan->total_harga - (float) $sudahBayar);

            // Tambah denda jika sewa barang
            $totalDenda = 0;
            if ($pesanan->jenis === 'sewa_barang') {
                $pengembalian = PengembalianBarang::whereHas(
                    'detailPemesanan',
                    fn($q) => $q->where('pemesanan_id', $pesanan->id)
                )->first();
                $totalDenda = $pengembalian ? (float) $pengembalian->total_denda : 0;
            }

            $jumlahBayar = $sisaSewa + $totalDenda;
            $tahap       = 'pelunasan';
            $persenDp    = null;
        } else {
            $tahap       = 'dp';
            $persenDp    = 50;
            $jumlahBayar = round($pesanan->total_harga * 0.5);
        }

        $pembayaran = $pesanan->pembayarans()
            ->where('tahap', $tahap)
            ->where('status', 'menunggu')
            ->latest()
            ->first();

        if ($pembayaran) {
            $pembayaran->update([
                'persen_dp'    => $persenDp,
                'jumlah_bayar' => $jumlahBayar,
            ]);
            $kodeTransaksi = $pembayaran->kode_transaksi;
        } else {
            $kodeTransaksi = 'TRX-' . strtoupper(Str::random(8));

            $pembayaran = $pesanan->pembayarans()->create([
                'kode_transaksi'    => $kodeTransaksi,
                'tahap'             => $tahap,
                'persen_dp'         => $persenDp,
                'jumlah_bayar'      => $jumlahBayar,
                'metode_pembayaran' => 'midtrans',
                'status'            => 'menunggu',
                'dibayar_pada'      => null,
            ]);
        }

        $user      = $pesanan->user;
        $namaParts = explode(' ', $user->name, 2);

        $params = [
            'transaction_details' => [
                'order_id'     => $kodeTransaksi,
                'gross_amount' => (int) $jumlahBayar,
            ],
            'customer_details' => [
                'first_name' => $namaParts[0],
                'last_name'  => $namaParts[1] ?? '',
                'email'      => $user->email,
                'phone'      => $pesanan->no_hp,
            ],
            'callbacks' => [
                'finish' => route('user.pembayaran.finish'),
            ],
        ];

        $snapToken = $this->midtrans->createSnapToken($params);

        $pembayaran->update(['snap_token' => $snapToken]);

        return view('user.pemesanan.snap-payment', compact('snapToken', 'pembayaran', 'pesanan'));
    }

    public function finish(Request $request): RedirectResponse
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('user.pemesanan.index')
                ->with('info', 'Pembayaran diproses.');
        }

        $pembayaran = \App\Models\Pembayaran::where('kode_transaksi', $orderId)
            ->with('pemesanan')
            ->first();

        if (!$pembayaran) {
            return redirect()->route('user.pemesanan.index');
        }

        // FALLBACK: Cek status langsung ke Midtrans jika webhook gagal di environment lokal
        if ($pembayaran->status === 'menunggu') {
            try {
                $statusResponse = \Midtrans\Transaction::status($orderId);
                $transactionStatus = $statusResponse->transaction_status ?? null;
                $fraudStatus = $statusResponse->fraud_status ?? null;

                if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
                    $channel = $this->extractPaymentChannel($statusResponse);

                    $pembayaran->update([
                        'status'         => 'terverifikasi',
                        'dibayar_pada'   => now(),
                        'gateway_status' => $transactionStatus,
                        'payment_type'   => $channel['payment_type'],
                        'bank'           => $channel['bank'],
                        'va_number'      => $channel['va_number'],
                    ]);

                    $pesanan = $pembayaran->pemesanan;
                    $pesanan->load('user');

                    if ($pembayaran->tahap === 'pelunasan') {
                        $pesanan->update(['status' => 'selesai']);
                    } elseif ($pesanan->jenis === 'sewa_barang') {
                        $pesanan->update(['status' => 'menunggu_diambil']);
                    } else {
                        $pesanan->update(['status' => 'berlangsung']);
                    }

                    \Illuminate\Support\Facades\Mail::to($pesanan->user->email)->queue(new \App\Mail\PembayaranBerhasilMail($pesanan, $pembayaran->tahap));
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $pembayaran->update([
                        'status'         => 'ditolak',
                        'gateway_status' => $transactionStatus,
                    ]);
                }
            } catch (\Exception $e) {
                // Abaikan jika tidak bisa menghubungi API
            }
        }

        $pembayaran->refresh();

        if ($pembayaran->status === 'terverifikasi') {
            $flash = ['info', 'Pembayaran berhasil dikonfirmasi. Status pesanan Anda telah diperbarui!'];
        } elseif ($pembayaran->status === 'ditolak') {
            $flash = ['error', 'Pembayaran dibatalkan atau ditolak. Silakan coba lagi.'];
        } else {
            $flash = ['info', 'Pembayaran sedang diproses. Status akan diperbarui begitu konfirmasi diterima.'];
        }

        return redirect()->route('user.pemesanan.show', $pembayaran->pemesanan_id)
            ->with(...$flash);
    }

    public function callback(Request $request): JsonResponse
    {
        $notification = $this->midtrans->getNotification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;

        $pembayaran = \App\Models\Pembayaran::where('kode_transaksi', $orderId)
            ->with('pemesanan')
            ->first();

        if (!$pembayaran) {
            return response()->json(['message' => 'not found'], 404);
        }

        $channel = $this->extractPaymentChannel($notification);

        $pembayaran->update([
            'gateway_transaction_id' => $notification->transaction_id,
            'gateway_status'         => $transactionStatus,
            'payment_type'           => $channel['payment_type'],
            'bank'                   => $channel['bank'],
            'va_number'              => $channel['va_number'],
        ]);

        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            $pembayaran->update([
                'status'       => 'terverifikasi',
                'dibayar_pada' => now(),
            ]);

            $pesanan = $pembayaran->pemesanan;
            $pesanan->load('user');

            if ($pembayaran->tahap === 'pelunasan') {
                $pesanan->update(['status' => 'selesai']);
            } elseif ($pesanan->jenis === 'sewa_barang') {
                // DP sewa barang → tunggu diambil oleh user
                $pesanan->update(['status' => 'menunggu_diambil']);
            } else {
                // DP / lunas acara → langsung berlangsung
                $pesanan->update(['status' => 'berlangsung']);
            }

            Mail::to($pesanan->user->email)->queue(new PembayaranBerhasilMail($pesanan, $pembayaran->tahap));
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $pembayaran->update(['status' => 'ditolak']);
        }

        return response()->json(['message' => 'ok']);
    }

    /**
     * @return array{payment_type: ?string, bank: ?string, va_number: ?string}
     */
    private function extractPaymentChannel(object|array $data): array
    {
        $data = is_array($data) ? json_decode(json_encode($data)) : $data;

        $bank     = null;
        $vaNumber = null;

        if (!empty($data->va_numbers)) {
            $bank     = $data->va_numbers[0]->bank ?? null;
            $vaNumber = $data->va_numbers[0]->va_number ?? null;
        } elseif (!empty($data->permata_va_number)) {
            $bank     = 'permata';
            $vaNumber = $data->permata_va_number;
        } elseif (!empty($data->bill_key)) {
            $bank     = 'mandiri';
            $vaNumber = $data->bill_key;
        } elseif (!empty($data->payment_code)) {
            $bank     = $data->store ?? null;
            $vaNumber = $data->payment_code;
        }

        return [
            'payment_type' => $data->payment_type ?? null,
            'bank'         => $bank,
            'va_number'    => $vaNumber,
        ];
    }
}
