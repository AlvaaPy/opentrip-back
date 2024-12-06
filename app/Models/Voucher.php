<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $primaryKey = 'voucherID';
    protected $fillable = [
       'voucher_code',
       'picture',
       'fixed_discount',
       'percentage_discount',
       'voucher_type',
       'tripID',
       'valid_from',
       'valid_util',
       'is_active',
    ];

    public function packageTrip()
    {
        return $this->belongsTo(PackageTrip::class, 'tripID', 'tripID');
    }
}
