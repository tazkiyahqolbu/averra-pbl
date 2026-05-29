<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KategoriJasa extends Model
{
    use HasFactory;

    protected $table = 'kategori_jasa';

    protected $fillable = ['nama', 'deskripsi', 'ikon_path']; // ← url_ikon → ikon_path

    public function jasas()
    {
        return $this->hasMany(Jasa::class, 'kategori_jasa_id'); // ← kategori_id → kategori_jasa_id
    }

    public function getIkonUrlAttribute(): ?string
    {
        return $this->ikon_path ? Storage::url($this->ikon_path) : null;
    }
}
