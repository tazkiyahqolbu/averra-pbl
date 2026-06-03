<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlokirTanggal extends Model
{
    use HasFactory;

    protected $table = 'blokir_tanggal';

    protected $fillable = [
        'tanggal',
        'full_block',
        'keterangan',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'full_block' => 'boolean',
    ];
}
