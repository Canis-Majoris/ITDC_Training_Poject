<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::create('projects', function($table)
		{
			$table->increments('id');
		    $table->integer('user_id');
		    $table->string('currency');
		    $table->tinyInteger('work_type');
		    $table->string('name');
		    $table->text('description');
		    $table->string('duration');
		    $table->tinyInteger('project_type_id');
		    $table->integer('avg_price');
		    $table->integer('avg_price_hourly');
		    $table->string('salary');
		    $table->integer('bid_count')->default(0);
		    $table->tinyInteger('active');
		    $table->text('files');
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
		Schema::drop('projects');
	}

}
