<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponSpecific extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'specific_id',
        'specific_type',
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function specific()
    {
        return $this->morphTo(null, 'specific_type', 'specific_id');
    }
}
