<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FotoBarang extends Model
{
    use HasFactory;

    protected $table = 'foto_barang';

    protected $fillable = ['barang_id', 'foto_path', 'keterangan', 'urutan']; // ← url_foto → foto_path

    protected $casts = ['urutan' => 'integer'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return Storage::url($this->foto_path);
    }
}
