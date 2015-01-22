<?php
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class CourseTableSeeder extends Seeder {
	public function run()
	{
		Course::truncate();
		Course::create(['name'=>'ინტერფეისის დეველოპმენტი']);
		Course::create(['name'=>'ვებ პროგრამირება და მონაცემთა ბაზები']);
		Course::create(['name'=>'ვებ დიზაინი']);
		Course::create(['name'=>'ვებ ადმინისტრირება']);
		Course::create(['name'=>'Linux სისტემების ადმინისტრირება']);
		Course::create(['name'=>'ინტერნეტ მარკეტინგი']);
	}
}