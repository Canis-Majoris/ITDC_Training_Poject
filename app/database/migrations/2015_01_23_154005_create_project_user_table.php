<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('project_id');
			$table->float('bid_price');
			$table->string('duration');
			$table->text('comment');
			$table->timestamps();
			$table->unique( ['user_id','project_id'] );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_user');
	}

}
