<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPagamentoHistoricoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pagamento_historicos', function(Blueprint $table)
		{
			$table->foreign('pagamento_id', 'fk_pagamentos_historico')->references('id')->on('pagamentos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pagamento_historicos', function(Blueprint $table)
		{
			$table->dropForeign('fk_pagamentos_historico');
		});
	}

}
