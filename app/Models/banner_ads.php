<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class banner_ads extends Model
{
    use HasFactory;
    protected $table = 'banner_ads';
    protected $primaryKey = 'bannerID';
    protected $fillable = [
        'banner_assets',
        'description',
    ];
}
