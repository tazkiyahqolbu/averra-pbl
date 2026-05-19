<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianBarang extends Model
{
    use HasFactory;

    protected $table = 'pengembalian_barang';

    protected $fillable = [
        'booking_detail_id',
        'tanggal_kembali_aktual',
        'kondisi',
        'catatan_kerusakan',
        'foto_bukti',
        'denda_keterlambatan',
        'denda_kerusakan',
        'total_denda',
        'status_denda',
        'dicatat_oleh',
    ];

    protected $casts = [
        'tanggal_kembali_aktual' => 'date',
        'denda_keterlambatan'    => 'decimal:2',
        'denda_kerusakan'        => 'decimal:2',
        'total_denda'            => 'decimal:2',
    ];

    public function bookingDetail()
    {
        return $this->belongsTo(BookingDetail::class);
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
