<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('UserTableSeeder');
		$this->call('SkillTableSeeder');
		$this->call('SkillUserTableSeeder');
		$this->call('CourseTableSeeder');
		$this->call('CourseUserTableSeeder');
		$this->call('CurrencyTableSeeder');
		$this->call('Project_typeTableSeeder');
		$this->call('SkillProjectTableSeeder');
		  //$this->call('CommentTableSeeder');

	}

}
