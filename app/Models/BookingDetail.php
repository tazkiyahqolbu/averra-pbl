<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    protected $table = 'booking_detail';

    protected $fillable = [
        'booking_id',
        'barang_id',
        'jasa_id',
        'paket_id',
        'jumlah',
        'harga',
        'subtotal',
        'tanggal_ambil',
        'tanggal_kembali',
    ];

    protected $casts = [
        'jumlah'          => 'integer',
        'harga'           => 'decimal:2',
        'subtotal'        => 'decimal:2',
        'tanggal_ambil'   => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class)->withDefault();
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class)->withDefault();
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class)->withDefault();
    }

    public function pengembalianBarang()
    {
        return $this->hasOne(PengembalianBarang::class);
    }
}
