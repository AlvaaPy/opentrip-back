<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTrip extends Model
{
    use HasFactory;

    protected $table = 'package_trip';
    protected $primaryKey = 'tripID';
    protected $fillable = [
        'namaTrip',
        'cityID',
        'alamat',
        'deskripsi',
        'meeting_point',
        'price',
        'start_date',
        'end_date',
        'rating',
        'picture',
    ];

    // Relasi ke City
    public function city()
    {
        return $this->belongsTo(Cities::class, 'cityID', 'cityID');
    }
}
