<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $primaryKey = 'reservationID';
    protected $fillable = [
        'userID',
        'tripID',
        'jumlah_peserta',
        'nama_pemesan',
        'email_pemesan',
        'no_telepon_pemesan',
        'meeting_points',
        'tgl_reservation',
        'tgl_start',
        'tgl_end',
        'total_harga',
        'voucherID',
        'status',
        'participants',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function packageTrip()
    {
        return $this->belongsTo(PackageTrip::class, 'tripID', 'tripID');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucherID', 'voucherID');
    }
}
