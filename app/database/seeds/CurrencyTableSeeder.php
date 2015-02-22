<?php
class CurrencyTableSeeder extends Seeder {
	public function run()
	{
		Currency::truncate();
		Currency::create(['name'=>'USD']);
		Currency::create(['name'=>'GEL']);
		Currency::create(['name'=>'AUD']);
		Currency::create(['name'=>'CAD']);
		Currency::create(['name'=>'EUR']);
		Currency::create(['name'=>'GBP']);
	}
}