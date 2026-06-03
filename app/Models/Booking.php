<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'service',
        'date',
        'location',
        'notes',
        'groom_name',
        'bride_name',
        'witness_name',
        'mahar',
        'status',
        'created_by',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            if (empty($booking->id)) {
                $booking->id = 'BK-' . strtoupper(bin2hex(random_bytes(3)));
            }
        });
    }
}
