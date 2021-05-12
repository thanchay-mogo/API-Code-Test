<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponShop extends Model
{
    protected $fillable = [
        'coupon_id', 'shop_id'
    ];

    public function shop()
    {
        return $this->hasMany(\App\shop::class);
    }

    public function coupon()
    {
        return $this->hasMany(\App\coupon::class);
    }
}
