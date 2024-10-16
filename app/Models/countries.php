<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $primaryKey = 'countryID';
    protected $fillable = [
        'country_name'
    ];

    // Definisi hubungan ke Provinces
    public function provinces()
    {
        return $this->hasMany(Provinces::class, 'countryID', 'countryID');
    }
}
