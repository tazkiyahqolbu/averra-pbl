<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPaket extends Model
{
    use HasFactory;

    protected $table = 'foto_paket';

    protected $fillable = [
        'paket_id',
        'url_foto',
        'keterangan',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }
}
