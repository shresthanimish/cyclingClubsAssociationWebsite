<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;

class EntrantFactory extends Factory
{
	/**
	 * Define the model's default state.
	 * @return array
	 */
	public function definition()
	{
		static $places = [];
		$race = \App\Models\Race::all()->random();
		$raceDate = new DateTime($race->race_date);
		$now = new DateTime();
		if ( $raceDate->getTimestamp() < $now->getTimestamp() )
		{
			if ( !isset($places[$race->id]) )
			{
				$places[$race->id] = 1;
			}
			else
			{
				$places[$race->id]++;
			}
			$place = $places[$race->id];
		}
		else
		{
			$place = NULL;
		}

		return [
			'race_id' => $race->id,
			'rider_id' => \App\Models\Rider::all()->random()->id,
			'place' => $place,
		];
	}
}
