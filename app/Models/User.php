<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'userID';
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'noTlpn',
        'birthDate',
        'gender',
        'otp',               // Kolom untuk OTP
        'otp_expires_at',    // Kolom untuk kadaluarsa OTP
        'email_verified_at', // Kolom untuk status verifikasi email
        'pin',
        "profile_picture"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthDate' => 'date',
        'email_verified_at' => 'datetime',  // Cast untuk verifikasi email
        'otp_expires_at' => 'datetime',     // Cast untuk waktu kadaluarsa OTP
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Generate OTP and store it in the database.
     */
    public function generateOtp()
    {
        // Generate OTP 6 digit
        $otp = mt_rand(100000, 999999);

        // Set waktu kadaluarsa OTP (10 menit dari sekarang)
        $this->otp_expires_at = now()->addMinutes(3);

        // Simpan OTP dan waktu kadaluarsa
        $this->otp = $otp;
        $this->save();

        return $otp;
    }


    /**
     * Verify the OTP entered by the user.
     */
    // Di dalam model User
    public function verifyOtp($otp)
    {
        // Cek apakah OTP yang diberikan cocok
        if ($this->otp == $otp) {
            // Jika OTP valid, set waktu verifikasi email
            $this->email_verified_at = now(); // Set waktu verifikasi
            $this->otp = null; // Hapus OTP setelah verifikasi
            $this->save();
            return true; // OTP berhasil diverifikasi
        }
        return false; // OTP tidak valid
    }
}
