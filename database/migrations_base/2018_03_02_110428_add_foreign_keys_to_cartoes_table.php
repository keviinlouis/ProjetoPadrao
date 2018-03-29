<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCartoesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cartoes', function(Blueprint $table)
		{
			$table->foreign('dono_id', 'fk_cartoes_donos1')->references('id')->on('donos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cartoes', function(Blueprint $table)
		{
			$table->dropForeign('fk_cartoes_donos1');
		});
	}

}
