<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RiderFactory extends Factory
{
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		return [
			'user_id' => \App\Models\User::select("*")->where('role', \App\Models\User::ROLE_RIDER)->inRandomOrder()->first()->id,
			'grading' => $this->faker->numberBetween(\App\Models\Rider::GRADING_LOWER, \App\Models\Rider::GRADING_UPPER),
			'age' => $this->faker->numberBetween(\App\Models\Rider::AGE_LOWER, \App\Models\Rider::AGE_UPPER),
			'gender' => $this->faker->randomElement(array_keys(\App\Models\Rider::getGenderOptions())),
			'club_id' => \App\Models\Club::all()->random()->id,
		];
	}
}
