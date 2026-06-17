<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PengembalianBarang extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_barang';

    protected $fillable = [
        'detail_pemesanan_id',           // ← booking_detail_id → detail_pemesanan_id
        'tanggal_kembali_aktual', 'kondisi',
        'catatan_kerusakan', 'foto_bukti_path', // ← foto_bukti → foto_bukti_path
        'status_pengembalian',           // ← field baru
        'denda_keterlambatan', 'denda_kerusakan',
        'total_denda', 'status_denda', 'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal_kembali_aktual' => 'date',
        'denda_keterlambatan'    => 'decimal:2',
        'denda_kerusakan'        => 'decimal:2',
        'total_denda'            => 'decimal:2',
    ];

    public function detailPemesanan()
    {
        return $this->belongsTo(DetailPemesanan::class, 'detail_pemesanan_id');
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    public function getFotoBuktiUrlAttribute(): ?string
    {
        return $this->foto_bukti_path
            ? Storage::url($this->foto_bukti_path)
            : null;
    }

    // Alias untuk view compatibility
    public function getTanggalKembaliJadwalAttribute()
    {
        return $this->detailPemesanan?->tanggal_kembali;
    }

    public function getDendaAttribute()
    {
        return $this->total_denda;
    }

    public function getCatatanAttribute()
    {
        return $this->catatan_kerusakan;
    }
}
