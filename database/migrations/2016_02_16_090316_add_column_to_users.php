<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
		    $table->string('telephone');
		    $table->string('education');
		    $table->string('school_year');
		    $table->string('overzicht_werk');
		    $table->string('kostenplaatje');
		    $table->string('bezorg_adres');
		    $table->string('domein_afdeling');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
