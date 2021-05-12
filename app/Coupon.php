<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'admin_id', 'name','description','discount_type','amount','code',''
    ];

    public function couponshop()
    {
        return $this->belongsTo(\App\couponshop::class);
    }
}
