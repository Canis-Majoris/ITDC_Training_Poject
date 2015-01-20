<?php
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class CourseUserTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();
		$users = User::all();
		$course_num = Course::all()->count();
		DB::table('course_user')->truncate();
		foreach($users as $user) {
			
			if ($user->type==0||$user->type==1) {
				$num = $faker->numberBetween(0, $course_num);
				$courses = Course::orderByRaw('RAND()')->limit($num)->get();
				$sk = [];
				foreach($courses as $course) {
					$sk[$course->id] = ['mark' => $faker->numberBetween(1, 100)];
				}
				$user->courses()->attach($sk);
			}
			
		}
	}
}