<?php
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class CourseTableSeeder extends Seeder {
	public function run()
	{
		Skill::truncate();
		Skill::create(['name'=>'ინტერფეისის დეველოპმენტი']);
		Skill::create(['name'=>'ვებ პროგრამირება და მონაცემთა ბაზები']);
		Skill::create(['name'=>'ვებ დიზაინი']);
		Skill::create(['name'=>'ვებ ადმინისტრირება']);
		Skill::create(['name'=>'Linux სისტემების ადმინისტრირება']);
		Skill::create(['name'=>'ინტერნეტ მარკეტინგი']);
	}
}