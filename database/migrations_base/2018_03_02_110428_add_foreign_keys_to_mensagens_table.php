<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMensagensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mensagens', function(Blueprint $table)
		{
			$table->foreign('destinatario_id', 'fk_destinatario')->references('id')->on('donos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('remetente_id', 'fk_remetente')->references('id')->on('donos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mensagens', function(Blueprint $table)
		{
			$table->dropForeign('fk_destinatario');
			$table->dropForeign('fk_remetente');
		});
	}

}
