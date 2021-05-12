<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {

		$table->integer('id',10)->unsigned();
		$table->char('uuid',36);
		$table->string('username',128)->nullable()->default('NULL');
		$table->string('email',128)->nullable()->default('NULL');
		$table->string('password',64)->nullable()->default('NULL');
		$table->datetime('deleted_at')->nullable()->default('NULL');
		$table->datetime('created_at');
		$table->datetime('updated_at');

        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
}