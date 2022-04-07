<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\App\Models\User::insert([
			[
				'first_name' => 'Robert',
				'surname' => 'Alfaro',
				'email' => 'info@rhombus.com.au',
				'password' => Hash::make('password'),
				'role' => \App\Models\User::ROLE_ADMIN,
				'club_id' => NULL,
				'status' => \App\Models\User::$STATUS_ACTIVE,
			]
		]);

		\App\Models\User::factory()->count(60)->create();
	}
}
