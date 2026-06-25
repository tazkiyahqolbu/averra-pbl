<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Jasa;
use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\ZonaLokasi;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PemesananController extends Controller
{
    public function index(): View
    {
        $status = request('status', 'semua');
        $userId = Auth::id();

        $query = Pemesanan::with([
            'detailPemesanans.barang',
            'detailPemesanans.jasa',
            'detailPemesanans.paket',
        ])->where('user_id', $userId)->latest();

        if ($status === 'pengembalian') {
            $query->where('jenis', 'sewa_barang')->where('status', 'berlangsung');
        } elseif ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pesanans = $query->get();

        return view('user.pemesanan.index', compact('pesanans'));
    }

    public function show($id): View
    {
        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->with([
                'detailPemesanans.barang',
                'detailPemesanans.jasa',
                'detailPemesanans.paket',
                'detailPemesanans.pengembalianBarang',
                'pembayarans',
                'testimoni',
            ])
            ->findOrFail($id);

        return view('user.pemesanan.show', compact('pesanan'));
    }

    public function createAcara(Request $request): View
    {
        $katalogs = collect()
            ->merge(Jasa::all()->map(fn($j) => [
                'id'       => 'jasa-' . $j->id,
                'name'     => $j->nama_jasa,
                'price'    => (float) $j->harga,
                'category' => 'Jasa',
            ]))
            ->merge(Paket::all()->map(fn($p) => [
                'id'       => 'paket-' . $p->id,
                'name'     => $p->nama_paket,
                'price'    => (float) $p->harga,
                'category' => 'Paket',
            ]));

        $zonaLokasis = ZonaLokasi::all()->map(fn($z) => [
            'id'        => $z->id,
            'nama_zona' => $z->nama_zona,
            'tarif'     => (float) $z->biaya,
        ]);

        $item = $this->resolveItemFromQuery($request->query('item'), ['jasa', 'paket']);

        return view('user.pemesanan.createacara', compact('katalogs', 'item', 'zonaLokasis'));
    }

    public function createSewa(Request $request): View
    {
        $katalogs = Barang::where('stok', '>', 0)->where('aktif', true)->get()->map(fn($b) => [
            'id'       => 'barang-' . $b->id,
            'name'     => $b->nama_barang,
            'price'    => (float) $b->harga,
            'category' => 'Sewa Barang',
        ]);

        $zonaLokasis = ZonaLokasi::all()->map(fn($z) => [
            'id'        => $z->id,
            'nama_zona' => $z->nama_zona,
            'tarif'     => (float) $z->biaya,
        ]);

        $item = $this->resolveItemFromQuery($request->query('item'), ['barang']);

        return view('user.pemesanan.createsewa', compact('katalogs', 'item', 'zonaLokasis'));
    }

    private function resolveItemFromQuery(?string $slug, array $allowedTypes): ?array
    {
        if (!$slug) return null;

        $parts  = explode('-', $slug, 2);
        $type   = $parts[0] ?? null;
        $typeId = $parts[1] ?? null;

        if (!$typeId || !in_array($type, $allowedTypes)) return null;

        try {
            if ($type === 'jasa') {
                $model = Jasa::findOrFail($typeId);
                return ['id' => $slug, 'name' => $model->nama_jasa, 'price' => (float) $model->harga, 'category' => 'Jasa'];
            }
            if ($type === 'paket') {
                $model = Paket::findOrFail($typeId);
                return ['id' => $slug, 'name' => $model->nama_paket, 'price' => (float) $model->harga, 'category' => 'Paket'];
            }
            if ($type === 'barang') {
                $model = Barang::findOrFail($typeId);
                return ['id' => $slug, 'name' => $model->nama_barang, 'price' => (float) $model->harga, 'category' => 'Sewa Barang'];
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    public function store(StoreBookingRequest $request): RedirectResponse
    {

        // Parse "barang-3" → ['barang', '3']
        [$jenisItem, $itemId] = explode('-', $request->katalog_id, 2);

        $harga    = 0;
        $barangId = $jasaId = $paketId = null;
        $jenis    = 'acara';

        if ($jenisItem === 'barang') {
            $model    = Barang::findOrFail($itemId);
            $harga    = (float) $model->harga;
            $barangId = $itemId;
            $jenis    = 'sewa_barang';
        } elseif ($jenisItem === 'jasa') {
            $model  = Jasa::findOrFail($itemId);
            $harga  = (float) $model->harga;
            $jasaId = $itemId;
        } else {
            $model   = Paket::findOrFail($itemId);
            $harga   = (float) $model->harga;
            $paketId = $itemId;
        }

        // Zona & ongkos
        $zonaId       = $request->filled('zona_lokasi_id') ? $request->zona_lokasi_id : null;
        $ongkosLokasi = 0;
        if ($zonaId) {
            $ongkosLokasi = (float) (ZonaLokasi::find($zonaId)?->biaya ?? 0);
        }

        // Tanggal pakai
        $tanggalPakai = $request->tanggal_pelaksanaan ?? $request->tanggal_ambil;

        // Durasi & subtotal
        $jumlah   = max(1, (int) ($request->jumlah_unit ?? 1));
        $durasi   = 1;
        if ($jenis === 'sewa_barang' && $request->tanggal_ambil && $request->tanggal_kembali) {
            $durasi = max(1, Carbon::parse($request->tanggal_ambil)
                ->diffInDays(Carbon::parse($request->tanggal_kembali)) + 1);
        }
        $subtotal = $harga * $jumlah * $durasi;

        // Hitung total di server — nilai dari form tidak dipercaya karena bisa dimanipulasi
        $totalHarga = $subtotal + $ongkosLokasi;

        // Buat Pemesanan
        $pemesanan = Pemesanan::create([
            'kode_pemesanan'    => 'PMB-' . strtoupper(Str::random(8)),
            'user_id'           => Auth::id(),
            'zona_id'           => $zonaId,
            'tanggal_pemesanan' => now()->toDateString(),
            'tanggal_pakai'     => $tanggalPakai,
            'jenis'             => $jenis,
            'lokasi'            => $request->alamat_lengkap,
            'ongkos_lokasi'     => $ongkosLokasi,
            'no_hp'             => $request->no_hp,
            'nama_pemesan'      => $request->nama_pemesan,
            'catatan'           => $request->keterangan_acara,
            'total_harga'       => $totalHarga,
            'status'            => 'menunggu',
        ]);

        // Buat DetailPemesanan
        $pemesanan->detailPemesanans()->create([
            'jenis_item'      => $jenisItem,
            'barang_id'       => $barangId,
            'jasa_id'         => $jasaId,
            'paket_id'        => $paketId,
            'jumlah'          => $jumlah,
            'harga'           => $harga,
            'subtotal'        => $subtotal,
            'tanggal_ambil'   => $request->tanggal_ambil,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        // Catat pilihan metode bayar di tabel pembayaran
        $metodeBayar = $request->metode_bayar ?? 'dp';
        $tahap = $metodeBayar === 'lunas' ? 'langsung' : 'dp';
        $pemesanan->pembayarans()->create([
            'kode_transaksi'    => 'TRX-' . strtoupper(Str::random(8)),
            'tahap'             => $tahap,
            'persen_dp'         => $tahap === 'langsung' ? 100 : 50,
            'jumlah_bayar'      => $tahap === 'langsung' ? $totalHarga : round($totalHarga * 0.5),
            'metode_pembayaran' => 'transfer',
            'status'            => 'menunggu',
            'dibayar_pada'      => null,
        ]);

        return redirect()->route('user.pemesanan.submitted', $pemesanan->id);
    }

    public function submitted($id): View
    {
        $pesanan = Pemesanan::where('user_id', Auth::id())
            ->with(['detailPemesanans.barang', 'detailPemesanans.jasa', 'detailPemesanans.paket', 'pembayarans'])
            ->findOrFail($id);

        return view('user.pemesanan.submitted', compact('pesanan'));
    }

    public function update($id): RedirectResponse
    {
        return redirect()->route('user.pemesanan.show', $id);
    }

    public function invoice($id): View
    {
        $pesanan = Pemesanan::with([
            'detailPemesanans.barang',
            'detailPemesanans.jasa',
            'detailPemesanans.paket',
            'zonaLokasi',
            'pembayarans',
        ])->where('user_id', Auth::id())->findOrFail($id);

        return view('user.invoice.show', compact('pesanan'));
    }
}
