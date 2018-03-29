<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagamentoHistoricosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagamento_historicos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('valor', 10);
			$table->text('descricao', 65535);
			$table->integer('status');
			$table->integer('pagamento_id')->unsigned()->index('fk_pagamentos_historico_idx');
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
		Schema::drop('pagamento_historicos');
	}

}
