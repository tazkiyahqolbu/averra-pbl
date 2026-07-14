<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $table = 'kategori_jasa';

    protected $fillable = ['nama', 'deskripsi'];

    public function jasas()
    {
        return $this->hasMany(Jasa::class, 'kategori_jasa_id');
    }
}
