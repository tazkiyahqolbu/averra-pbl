<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Jasa extends Model
{
    use HasFactory;

    protected $table = 'jasa';

    protected $fillable = [
        'kategori_jasa_id', 'nama_jasa', 'deskripsi',
        'harga', 'maks_booking_harian', 'thumbnail_path', 'aktif',
    ];

    protected $casts = [
        'harga'               => 'decimal:2',
        'maks_booking_harian' => 'integer',
        'aktif'               => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriJasa::class, 'kategori_jasa_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoJasa::class);
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
