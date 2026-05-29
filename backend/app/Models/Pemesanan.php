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
        'lokasi', 'ongkos_lokasi', 'no_hp',
        'catatan', 'total_harga', 'status',
    ];

    protected $casts = [
        'tanggal_pemesanan' => 'date',
        'tanggal_pakai'     => 'date',
        'ongkos_lokasi'     => 'decimal:2',
        'total_harga'       => 'decimal:2',
    ];

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

    public function testimonies()
    {
        return $this->hasMany(Testimoni::class, 'pemesanan_id');
    }
}
