<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KategoriPaket extends Model
{
    use HasFactory;

    protected $table = 'kategori_paket';

    protected $fillable = ['nama', 'deskripsi', 'ikon_path']; // ← url_ikon → ikon_path

    public function pakets()
    {
        return $this->hasMany(Paket::class, 'kategori_paket_id');
    }

    public function getIkonUrlAttribute(): ?string
    {
        return $this->ikon_path ? Storage::url($this->ikon_path) : null;
    }
}
