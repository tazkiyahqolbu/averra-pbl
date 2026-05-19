<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoJasa extends Model
{
    use HasFactory;

    protected $table = 'foto_jasa';

    protected $fillable = [
        'jasa_id',
        'url_foto',
        'keterangan',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}
