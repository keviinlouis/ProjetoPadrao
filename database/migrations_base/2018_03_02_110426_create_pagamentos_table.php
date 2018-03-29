<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagamentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pagamentos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('valor', 10);
			$table->text('descricao', 65535);
			$table->integer('status');
			$table->string('moip_id')->nullable();
			$table->integer('entity_id')->unsigned()->index('fk_pagamentos_entity1_idx');
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
		Schema::drop('pagamentos');
	}

}
