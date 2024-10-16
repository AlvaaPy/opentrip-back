<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cities extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primaryKey = 'cityID';
    protected $fillable = [
        'provinceID',
        'city_name'
    ];

    // Definisi hubungan ke Provinces
    public function province()
    {
        return $this->belongsTo(Provinces::class, 'provinceID', 'provinceID');
    }
}
