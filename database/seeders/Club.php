<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Club extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		\App\Models\Club::factory()->count(20)->create();
	}
}
