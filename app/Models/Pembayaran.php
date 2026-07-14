<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'kode_transaksi', 'pemesanan_id', 'tahap',
        'persen_dp', 'jumlah_bayar', 'dibayar_pada',
        'metode_pembayaran',
        'status', 'diverifikasi_oleh', 'diverifikasi_pada',
        'catatan_penolakan',
        'snap_token', 'gateway_transaction_id', 'gateway_status',
        'payment_type', 'bank', 'va_number',
    ];

    protected $casts = [
        'persen_dp'          => 'integer',
        'jumlah_bayar'       => 'decimal:2',
        'dibayar_pada'       => 'datetime', // ← dari 'date'
        'diverifikasi_pada'  => 'datetime',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
