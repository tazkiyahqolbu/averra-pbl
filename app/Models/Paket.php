<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    protected $fillable = [
        'kategori_paket_id', 'nama_paket', 'deskripsi',
        'harga', 'keterangan_acara', 'catatan', 'thumbnail_path', 'aktif', 'unggulan',
    ];

    protected $casts = [
        'harga'    => 'decimal:2',
        'aktif'    => 'boolean',
        'unggulan' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPaket::class, 'kategori_paket_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoPaket::class);
    }

    public function paketDetails()
    {
        return $this->hasMany(PaketDetail::class);
    }

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : null;
    }
}
