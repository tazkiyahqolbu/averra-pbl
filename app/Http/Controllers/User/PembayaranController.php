<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Services\MidtransService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        if (!in_array($pesanan->status, ['dikonfirmasi', 'berlangsung'])) {
            return redirect()->route('user.pemesanan.show', $id)
                ->with('error', 'Pesanan belum dikonfirmasi oleh admin.');
        }

        $sudahBayar = $pesanan->pembayarans
            ->where('status', 'terverifikasi')
            ->sum('jumlah_bayar');

        if ($sudahBayar >= $pesanan->total_harga) {
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
            ->with(['pembayarans', 'user'])
            ->findOrFail($id);

        if ($pesanan->status !== 'dikonfirmasi') {
            return back()->with('error', 'Pesanan belum dikonfirmasi.');
        }

        $isPelunasan = $pesanan->pembayarans
            ->where('tahap', 'dp')
            ->where('status', 'terverifikasi')
            ->isNotEmpty();

        if ($isPelunasan) {
            $sudahBayar   = $pesanan->pembayarans->where('status', 'terverifikasi')->sum('jumlah_bayar');
            $jumlahBayar  = max(0, $pesanan->total_harga - $sudahBayar);
            $tahap        = 'pelunasan';
            $persenDp     = null;
        } else {
            $pilihan     = $request->input('pilihan', 'dp');
            $tahap       = $pilihan === 'lunas' ? 'langsung' : 'dp';
            $persenDp    = $tahap === 'langsung' ? 100 : 50;
            $jumlahBayar = $tahap === 'langsung'
                ? $pesanan->total_harga
                : round($pesanan->total_harga * 0.5);
        }

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

        $user     = $pesanan->user;
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

        return redirect()->route('user.pemesanan.show', $pembayaran->pemesanan_id)
            ->with('info', 'Pembayaran sedang diproses. Status akan diperbarui otomatis.');
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

        $pembayaran->update([
            'gateway_transaction_id' => $notification->transaction_id,
            'gateway_status'         => $transactionStatus,
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
            } else {
                $pesanan->update(['status' => 'berlangsung']);
            }

            Mail::to($pesanan->user->email)->queue(new PembayaranBerhasilMail($pesanan, $pembayaran->tahap));
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $pembayaran->update(['status' => 'ditolak']);
        }

        return response()->json(['message' => 'ok']);
    }
}
