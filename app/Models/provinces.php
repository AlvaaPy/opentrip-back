<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class provinces extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $primaryKey = 'provinceID';
    protected $fillable = [
        'countryID',
        'province_name'
    ];

    // Definisi hubungan ke Countries
    public function country()
    {
        return $this->belongsTo(Countries::class, 'countryID', 'countryID');
    }
}
