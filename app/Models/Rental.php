<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $table = 'rentals';
    protected $primaryKey = 'rentalID';

    protected $fillable = [
        'nama_kendaraan',
        'kapasitas_kendaraan',
        'kapasitas_bagasi',
        'umur_kendaraan',
        'jenis_kendaraan',
        'deskripsi',
        'dengan_supir',
        'harga',
        'foto',
    ];

    public function images_rental()
    {
        return $this->hasMany(images_rentals::class, 'rentalID', 'rentalID');
    }
}
