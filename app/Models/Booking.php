<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'kode_booking',
        'user_id',
        'zona_id',
        'tanggal_booking',
        'tanggal_pakai',
        'jenis',
        'lokasi',
        'ongkos_lokasi',
        'no_hp',
        'catatan',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'tanggal_pakai'   => 'date',
        'ongkos_lokasi'   => 'decimal:2',
        'total_harga'     => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zonaLokasi()
    {
        return $this->belongsTo(ZonaLokasi::class, 'zona_id');
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function bookingOpsionals()
    {
        return $this->hasMany(BookingOpsional::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function testimonies()
    {
        return $this->hasMany(Testimoni::class);
    }
}
