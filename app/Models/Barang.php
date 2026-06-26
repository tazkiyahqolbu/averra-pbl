<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kategori_barang_id', 'nama_barang', 'deskripsi',
        'harga', 'nilai_barang', 'stok', 'thumbnail_path', 'aktif', // ← url_thumbnail → thumbnail_path
    ];

    protected $casts = [
        'harga'        => 'decimal:2',
        'nilai_barang' => 'decimal:2',
        'stok'         => 'integer',
        'aktif'        => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoBarang::class);
    }

    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class); // ← bookingDetails → detailPemesanans
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : null;
    }
}
