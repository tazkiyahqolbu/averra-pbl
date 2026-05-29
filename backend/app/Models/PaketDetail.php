<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketDetail extends Model
{
    use HasFactory;

    protected $table = 'paket_detail';

    protected $fillable = [
        'paket_id', 'jasa_id', 'nama_item',
        'jumlah', 'tipe', 'harga_tambahan', 'keterangan',
    ];

    protected $casts = [
        'jumlah'         => 'integer',
        'harga_tambahan' => 'decimal:2',
        // ← hapus cast jasa_id sebagai integer, tidak perlu
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class); // ← withDefault() dihapus
    }

    public function opsionalPemesanans()
    {
        return $this->hasMany(OpsionalPemesanan::class); // ← bookingOpsionals → opsionalPemesanans
    }
}
