<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RaceFactory extends Factory
{
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		return [
			'club_id' => \App\Models\Club::all()->random()->id,
			'title' => $this->faker->unique()->words(3, true),
			'race_date' => $this->faker->dateTimeBetween('-8 weeks', '+8 weeks'),
			'start_time' => $this->faker->numberBetween(0, 12) . $this->faker->randomElement(['am', 'pm']),
			'address' => $this->faker->streetAddress(),
			'suburb' => $this->faker->city(),
			'postcode' => substr($this->faker->postcode, 0, 4),
			'state_id' => \App\Models\State::all()->random()->id,
			'status' => $this->faker->randomElement(array_keys(\App\Models\Race::getStatusOptions())),
		];
	}
}
