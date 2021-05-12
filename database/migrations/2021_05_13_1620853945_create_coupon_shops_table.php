<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponShopsTable extends Migration
{
    public function up()
    {
        Schema::create('coupon_shops', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('coupon_id',10)->unsigned();
		$table->integer('shop_id',10)->unsigned();
		$table->datetime('created_at');
		$table->datetime('updated_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('coupon_shops');
    }
}