<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArtworkColourMaterial extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('artworks', function($table)
		{
		    $table->string('colour');
		    $table->string('material');
		});
	}

	/**
	 * Reverse the migrations. HEELLOOO
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
