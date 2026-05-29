<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pemesanan';

    protected $fillable = [
        'pemesanan_id', 'jenis_item',
        'barang_id', 'jasa_id', 'paket_id',
        'jumlah', 'harga', 'subtotal',
        'tanggal_ambil', 'tanggal_kembali',
    ];

    protected $casts = [
        'jumlah'          => 'integer',
        'harga'           => 'decimal:2',
        'subtotal'        => 'decimal:2',
        'tanggal_ambil'   => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class); // ← withDefault() dihapus
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);   // ← withDefault() dihapus
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class);  // ← withDefault() dihapus
    }

    public function pengembalianBarang()
    {
        return $this->hasOne(PengembalianBarang::class, 'detail_pemesanan_id');
    }
}
