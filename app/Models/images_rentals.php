<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class images_rentals extends Model
{
    use HasFactory;

    protected $table = 'images_rentals';
    protected $primaryKey = 'images_rental_id';
    protected $fillable = [
        'rentalID',
        'picture',
    ];

    public function rentals()
    {
        return $this->belongsTo(Rental::class, 'rentalID', 'rentalID');
    }
}
