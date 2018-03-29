<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecuperacaoSenhaDonosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('recuperacao_senha_donos', function(Blueprint $table)
		{
			$table->string('token', 191);
			$table->string('email', 191);
			$table->dateTime('created_at')->nullable();
			$table->dateTime('expires_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recuperacao_senha_donos');
	}

}
