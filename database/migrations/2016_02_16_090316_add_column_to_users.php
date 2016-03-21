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
		    $table->string('work_summary');
		    $table->string('price');
		    $table->string('delivery_address');
		    $table->string('zip');
		    $table->string('sector');
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
