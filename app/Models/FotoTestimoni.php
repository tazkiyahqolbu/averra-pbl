<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoTestimoni extends Model
{
    use HasFactory;

    protected $table = 'foto_testimoni';

    protected $fillable = [
        'testimoni_id',
        'url_foto',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function testimoni()
    {
        return $this->belongsTo(Testimoni::class);
    }
}
