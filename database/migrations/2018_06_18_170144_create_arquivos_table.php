<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArquivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('arquivos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome', 191);
			$table->string('extensao', 45)->nullable();
			$table->string('path', 191);
			$table->text('url', 65535)->nullable();
			$table->text('tipo', 65535)->nullable();
			$table->text('descricao', 65535)->nullable();
			$table->integer('entidade_id')->unsigned();
			$table->string('entidade_type', 191);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('arquivos');
	}

}
