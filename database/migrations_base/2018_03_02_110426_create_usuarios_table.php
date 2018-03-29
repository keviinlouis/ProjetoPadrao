<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdministradoresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('administradores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 191);
			$table->string('email', 191)->unique('email');
			$table->string('senha', 191);
			$table->boolean('is_master')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('administradores');
	}

}
