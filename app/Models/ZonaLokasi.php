<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaLokasi extends Model
{
    use HasFactory;

    protected $table = 'zona_lokasi';

    protected $fillable = [
        'nama_zona',
        'keterangan',
        'biaya',
    ];

    protected $casts = [
        'biaya' => 'decimal:2',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'zona_id');
    }
}
