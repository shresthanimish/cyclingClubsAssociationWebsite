<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 * @return void
	 */
	public function run()
	{
		$this->call(StateSeeder::class);
		$this->call(Club::class);
		$this->call(User::class);
		$this->call(Race::class);
		$this->call(Rider::class);
		$this->call(Entrant::class);
	}
}
