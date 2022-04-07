<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Race extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		\App\Models\Race::factory()->count(40)->create();
	}
}
