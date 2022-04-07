<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Entrant extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		\App\Models\Entrant::factory()->count(100)->create();
	}
}
