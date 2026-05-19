<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    use HasFactory;

    protected $table = 'testimoni';

    protected $fillable = [
        'user_id',
        'booking_id',
        'isi_testimoni',
        'rating',
        'dibalas',
        'dipublikasikan',
    ];

    protected $casts = [
        'rating'         => 'integer',
        'dipublikasikan' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function fotos()
    {
        return $this->hasMany(FotoTestimoni::class);
    }
}
