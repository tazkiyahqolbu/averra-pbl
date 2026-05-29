<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpsionalPemesanan extends Model
{
    use HasFactory;

    protected $table = 'opsional_pemesanan';

    protected $fillable = ['pemesanan_id', 'paket_detail_id', 'harga_tambahan'];

    protected $casts = ['harga_tambahan' => 'decimal:2'];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function paketDetail()
    {
        return $this->belongsTo(PaketDetail::class);
    }
}
