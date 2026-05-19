<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoBarang extends Model
{
    use HasFactory;

    protected $table = 'foto_barang';

    protected $fillable = [
        'barang_id',
        'url_foto',
        'keterangan',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
