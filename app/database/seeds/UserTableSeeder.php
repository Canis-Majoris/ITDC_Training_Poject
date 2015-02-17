<?php
use Faker\Factory as Faker;
class UserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		foreach (range(1, 100) as $index) {
			$name = $faker->username;
			$typeNum = $faker->numberBetween(0,3);
			$company = -1;
			if ($typeNum == 2||$typeNum == 3) {
				$company = $faker->company();
			}
			User::create([
				'email' => $faker->email,
				'active' => 1,
				'username' => $name,
				'password' => Hash::make($name),
				'firstname' => $faker->firstname(),
				'lastname' =>$faker->lastname(),
				'gender' => $faker->numberBetween(0,1),
				'type' => $typeNum,
				'status' => 1,
				'online' => $faker->numberBetween(0,1),
				'company_name' => $company,
				'reputation' => $faker->randomFloat(4,0),
				'description' => $faker->text,
				'company_name' => $company

			]);
		}

		// $this->call('UserTableSeeder');
	}

}
