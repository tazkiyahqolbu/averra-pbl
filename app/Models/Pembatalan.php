<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembatalan extends Model
{
    protected $table = 'pembatalan';

    protected $fillable = [
        'pemesanan_id', 'user_id', 'alasan',
        'nama_rekening', 'nomor_rekening', 'nama_bank',
        'status', 'catatan_admin', 'jumlah_refund',
        'diproses_oleh', 'bukti_transfer_path', 'diproses_pada',
    ];

    protected $casts = [
        'diproses_pada' => 'datetime',
        'jumlah_refund' => 'decimal:2',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diprosesoleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}
