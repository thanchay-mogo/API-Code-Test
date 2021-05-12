<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'admin_id', 'name'
    ];

    public function couponshop()
    {
        return $this->belongsTo(\App\couponshop::class);
    }
}
