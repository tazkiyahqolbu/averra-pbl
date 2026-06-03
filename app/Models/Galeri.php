<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'judul', 'kategori', 'media_path', // ← url_media → media_path
        'jenis_media', 'keterangan', 'unggulan',
    ];

    protected $casts = ['unggulan' => 'boolean'];

    public function getMediaUrlAttribute(): string
    {
        return Storage::url($this->media_path);
    }
}
