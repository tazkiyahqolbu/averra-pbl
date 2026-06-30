<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'kode_pemesanan', 'user_id', 'zona_id',
        'tanggal_pemesanan', 'tanggal_pakai', 'jenis',
        'lokasi', 'ongkos_lokasi', 'no_hp', 'nama_pemesan',
        'catatan', 'alasan_penolakan', 'total_harga', 'status',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'date',
        'tanggal_pakai'     => 'date',
        'ongkos_lokasi'     => 'decimal:2',
        'total_harga'       => 'decimal:2',
    ];

    // ── Status methods ─────────────────────────────────────────────────────────
    public function isMenungguKonfirmasi(): bool    { return $this->status === 'menunggu'; }
    public function isMenungguPembayaran(): bool    { return $this->status === 'dikonfirmasi'; }
    public function isBerlangsung(): bool           { return $this->status === 'berlangsung'; }
    public function isSelesai(): bool               { return $this->status === 'selesai'; }

    // ── Status sewa barang ─────────────────────────────────────────────────────
    public function isMenungguDp(): bool            { return $this->status === 'menunggu_dp'; }
    public function isMenungguDiambil(): bool       { return $this->status === 'menunggu_diambil'; }
    public function isSedangDisewa(): bool          { return $this->status === 'sedang_disewa'; }
    public function isMenungguPengembalian(): bool  { return $this->status === 'menunggu_pengembalian'; }
    public function isMenungguPelunasan(): bool     { return $this->status === 'menunggu_pelunasan'; }

    // ── Accessors ──────────────────────────────────────────────────────────────
    public function getKategoriOrderAttribute(): string
    {
        return $this->jenis === 'sewa_barang' ? 'sewa' : 'acara';
    }

    public function getMetodeBayarAttribute(): string
    {
        return $this->pembayarans()->orderBy('id')->value('tahap') ?? 'dp';
    }

    public function getPengembalianAttribute()
    {
        return PengembalianBarang::whereHas('detailPemesanan', fn($q) => $q->where('pemesanan_id', $this->id))
            ->with('detailPemesanan')
            ->first();
    }

    // ── Relations ──────────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zonaLokasi()
    {
        return $this->belongsTo(ZonaLokasi::class, 'zona_id');
    }

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id');
    }

    public function opsionalPemesanans()
    {
        return $this->hasMany(OpsionalPemesanan::class, 'pemesanan_id');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'pemesanan_id');
    }

    public function testimoni()
    {
        return $this->hasOne(Testimoni::class, 'pemesanan_id');
    }

    public function pembatalan()
    {
        return $this->hasOne(Pembatalan::class, 'pemesanan_id');
    }
}
