<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'kategori_barang_id',
        'nama_barang',
        'deskripsi',
        'harga',
        'stok',
        'url_thumbnail',
        'aktif',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok'  => 'integer',
        'aktif' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoBarang::class);
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
