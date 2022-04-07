<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Rider extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		\App\Models\Rider::factory()->count(30)->create();
	}
}
