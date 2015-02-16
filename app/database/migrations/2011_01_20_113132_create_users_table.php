<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
		    $table->string('username')->unique();
		    $table->string('password');
		    $table->string('password_temp');
		    $table->string('code');
		    $table->tinyInteger('active');
		    $table->string('firstname');
		    $table->string('lastname');
		    $table->string('email');
		    $table->string('company_name');
		    $table->text('description');
		    $table->tinyInteger('gender');
		    $table->tinyInteger('type');
		    $table->tinyInteger('status');
		    $table->tinyInteger('online');
		    $table->string('avatar');
		    $table->string('remember_token');
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
		Schema::drop('users');
	}
}