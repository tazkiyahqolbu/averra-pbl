<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPaket extends Model
{
    use HasFactory;

    protected $table = 'kategori_paket';

    protected $fillable = ['nama', 'deskripsi'];

    public function pakets()
    {
        return $this->hasMany(Paket::class, 'kategori_paket_id');
    }
}
