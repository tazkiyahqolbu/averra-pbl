<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FotoPaket extends Model
{
    use HasFactory;

    protected $table = 'foto_paket';

    protected $fillable = ['paket_id', 'foto_path', 'keterangan', 'urutan']; // ← url_foto → foto_path

    protected $casts = ['urutan' => 'integer'];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return Storage::url($this->foto_path);
    }
}
