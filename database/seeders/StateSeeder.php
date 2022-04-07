<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 * @return void
	 */
	public function run()
	{
		$states = [
			['name' => 'Australian Capital Territory', 'abbreviation' => 'ACT'],
			['name' => 'New South Wales', 'abbreviation' => 'NSW'],
			['name' => 'Northern Territory', 'abbreviation' => 'NT'],
			['name' => 'Queensland', 'abbreviation' => 'QLD'],
			['name' => 'South Australia', 'abbreviation' => 'SA'],
			['name' => 'Tasmania', 'abbreviation' => 'TAS'],
			['name' => 'Victoria', 'abbreviation' => 'VIC'],
			['name' => 'Western Australia', 'abbreviation' => 'WA'],
		];
		\App\Models\State::insert($states);
	}
}
