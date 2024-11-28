<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customTrip extends Model
{
    use HasFactory;
    
    protected $table = 'custom_trips';
    protected $primaryKey = 'customID';
    protected $fillable = [
        'userID',
        'nama_pemesan',
        'start_date',
        'end_date',
        'jumlah_peserta',
        'tripID',
        'judul_trip',
        'jenis_custom',
        'cityID',
        'alamat_detail',
        'catatan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    /**
     * Relasi ke model PackageTrip.
     * Menghubungkan tripID di tabel custom_trips dengan tripID di tabel package_trip.
     */
    public function packageTrip()
    {
        return $this->belongsTo(PackageTrip::class, 'tripID', 'tripID');
    }

    /**
     * Relasi ke model City.
     * Menghubungkan cityID di tabel custom_trips dengan cityID di tabel cities.
     */
    public function city()
    {
        return $this->belongsTo(cities::class, 'cityID', 'cityID');
    }
}
