<?php
use Faker\Factory as Faker;
class Project_typeTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();
		Project_type::truncate();
		Project_type::create(['name'=>'recruiter','description'=>$faker->text()]);
		Project_type::create(['name'=>'featured','description'=>$faker->text()]);
		Project_type::create(['name'=>'urgent','description'=>$faker->text()]);
		Project_type::create(['name'=>'sealed','description'=>$faker->text()]);
		Project_type::create(['name'=>'private','description'=>$faker->text()]);
		Project_type::create(['name'=>'fulltime','description'=>$faker->text()]);
		Project_type::create(['name'=>'nda','description'=>$faker->text()]);
		
	}
}