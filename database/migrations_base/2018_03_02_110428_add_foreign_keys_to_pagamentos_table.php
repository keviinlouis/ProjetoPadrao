<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPagamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pagamentos', function(Blueprint $table)
		{
			$table->foreign('entity_id', 'fk_pagamentos_entity1')->references('id')->on('entitys')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pagamentos', function(Blueprint $table)
		{
			$table->dropForeign('fk_pagamentos_entity1');
		});
	}

}
