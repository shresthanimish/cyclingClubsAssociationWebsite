<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Contact extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		\App\Models\Contact::factory()->count(20)->create();
	}
}
