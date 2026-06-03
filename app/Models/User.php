<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; 
class User extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles;

    protected $fillable = ['nama', 'email', 'password', 'no_hp', 'peran'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed']; // ← hapus email_verified_at (kolom tidak ada)

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function testimonies()
    {
        return $this->hasMany(Testimoni::class);
    }

    public function pengembalianDicatat()
    {
        return $this->hasMany(PengembalianBarang::class, 'dicatat_oleh');
    }

    public function pembayaranDiverifikasi()
    {
        return $this->hasMany(Pembayaran::class, 'diverifikasi_oleh');
    }
}
