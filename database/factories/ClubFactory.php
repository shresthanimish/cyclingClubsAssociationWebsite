<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClubFactory extends Factory
{
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		return [
			'title' => $this->faker->unique()->company(),
			'address' => $this->faker->streetAddress(),
			'suburb' => $this->faker->city(),
			'postcode' => substr($this->faker->postcode, 0, 4),
			'state_id' => \App\Models\State::all()->random()->id,
		];
	}
}
