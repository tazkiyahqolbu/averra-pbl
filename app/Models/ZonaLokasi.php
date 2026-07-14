<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaLokasi extends Model
{
    use HasFactory;

    protected $table = 'zona_lokasi';

    protected $fillable = ['nama_zona', 'keterangan', 'biaya', 'persentase'];

    protected $casts = ['biaya' => 'decimal:2', 'persentase' => 'decimal:2'];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'zona_id'); // ← bookings → pemesanans
    }
}
