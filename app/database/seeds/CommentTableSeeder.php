<?php
use Faker\Factory as Faker;

class CommentTableSeeder extends Seeder 
{

	public function run()
	{
		DB::table('comments')->truncate();

		Comment::create(array(
			'user_idar' => 22,
			'project_id' => 3,
			'replaying_id' => 1,
			'body' => 'Look I am a test comment.'
		));

		Comment::create(array(
			'user_idar' => 22,
			'project_id' => 3,
			'body' => 'This is going to be super crazy.'
		));

		Comment::create(array(
			'user_idar' => 8,
			'project_id' => 3,
			'body' => 'I am a master of Laravel and Angular.'
		));
/*
		$faker = Faker::create();
		$user_num = User::all()->count();
		
		$comments = Comment::all();
		foreach (range(1, 100) as $index) {
			//$comment->body = $faker->text;
			$pt_id = $faker->numberBetween(3, 20);

			$n = 0;
			while(true){
				$n = $faker->numberBetween(4, 21);
				if($n > $pt_id){
					break;
				}
			}
			$pr_rep = $n;
			Comment::create(array(
				'user_id' => $faker->numberBetween(5, 30),
				'project_id' => $pt_id,
				'replaying_id' => $pr_rep,
				'body' => $faker->text
			));
		}*/
	}

}