<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
	/**
	 * Define the model's default state.
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$phoneNumber = str_replace('-', '', $this->faker->phoneNumber());
		$numberOfWords = rand(5, 15);
		$numberOfSentences = rand(3, 10);
		return [
			'name' => $this->faker->name(),
			'email' => $this->faker->safeEmail(),
			'phone' => $phoneNumber,
			'subject' => $this->faker->words($numberOfWords),
			'message' => $this->faker->paragraphs($numberOfSentences),
		];
	}
}

