<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('admin_id',10)->unsigned();
		$table->string('name',128);
		$table->string('description')->nullable()->default('NULL');
		$table->enum('discount_type',['percentage','fix-amount']);
		$table->integer('amount',11);
		$table->text('image_url')->nullable()->default('NULL');
		$table->integer('code',11)->default('0');
		$table->datetime('start_datetime')->nullable()->default('NULL');
		$table->datetime('end_datetime')->nullable()->default('NULL');
		$table->enum('coupon_type',['private','public'])->default('public');
		$table->integer('used_count',10)->unsigned()->default('0');
		$table->datetime('deleted_at')->nullable()->default('NULL');
		$table->datetime('created_at');
		$table->datetime('updated_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}