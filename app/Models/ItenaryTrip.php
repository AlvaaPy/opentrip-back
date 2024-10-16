<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItenaryTrip extends Model
{
    use HasFactory;

    protected $table = 'itenary_trip';
    protected $primaryKey = 'itenaryID';
    protected $fillable = [
        'tripID',
        'hari_ke',
        'deskripsi',
        'waktu_mulai',
        'waktu_selesai',
    ];

    // Relasi ke PackageTrip
    public function packageTrip()
    {
        return $this->belongsTo(PackageTrip::class, 'tripID', 'tripID');
    }
}
