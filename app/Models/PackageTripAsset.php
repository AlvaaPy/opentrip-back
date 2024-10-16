<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTripAsset extends Model
{
    use HasFactory;

    protected $table = 'package_trip_assets';
    protected $fillable = [
        'tripID',
        'picture',
    ];

    // Relasi ke PackageTrip
    public function packageTrip()
    {
        return $this->belongsTo(PackageTrip::class, 'tripID', 'tripID');
    }

}
