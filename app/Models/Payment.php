<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'kode_transaksi',
        'booking_id',
        'tahap',
        'persen_dp',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'persen_dp'        => 'integer',
        'jumlah_bayar'     => 'decimal:2',
        'tanggal_bayar'    => 'date',
        'diverifikasi_pada'=> 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
