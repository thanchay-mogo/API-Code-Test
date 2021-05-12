<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->integer('admin_id',10)->unsigned();
		$table->string('name',64);
		$table->string('query',64)->nullable()->default('NULL');
		$table->decimal('latitude',10,8)->default('0.00000000');
		$table->decimal('longitude',10,8)->default('0.00000000');
		$table->integer('zoom',10)->unsigned()->nullable()->default('NULL');
		$table->datetime('deleted_at')->nullable()->default('NULL');
		$table->datetime('created_at');
		$table->datetime('updated_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
}