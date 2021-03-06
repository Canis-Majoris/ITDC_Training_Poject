<?php
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class SkillProjectTableSeeder extends Seeder {
	public function run()
	{
		$faker = Faker::create();
		$projects = Project::all();
		$skill_num = Skill::all()->count();
		DB::table('project_skill')->truncate();
		foreach($projects as $project) {
			
			$num = $faker->numberBetween(0, $skill_num);
			$skills = Skill::orderByRaw('RAND()')->limit($num)->get();
			$sk = [];
			foreach($skills as $skill) {
				$sk[$skill->id] = ['level' => $faker->numberBetween(1, 100)];
			}
			$project->skills()->attach($sk);
		}
	}
}