<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FotoTestimoni extends Model
{
    use HasFactory;

    protected $table = 'foto_testimoni';

    protected $fillable = ['testimoni_id', 'foto_path', 'urutan']; // ← url_foto → foto_path

    protected $casts = ['urutan' => 'integer'];

    public function testimoni()
    {
        return $this->belongsTo(Testimoni::class);
    }

    public function getFotoUrlAttribute(): string
    {
        return Storage::url($this->foto_path);
    }
}
