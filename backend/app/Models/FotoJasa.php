<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FotoJasa extends Model
{
    use HasFactory;

    protected $table = 'foto_jasa';

    protected $fillable = ['jasa_id', 'foto_path', 'keterangan', 'urutan']; // ← url_foto → foto_path

    protected $casts = ['urutan' => 'integer'];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return Storage::url($this->foto_path);
    }
}
