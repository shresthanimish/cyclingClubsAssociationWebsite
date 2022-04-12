<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\CommonFeatureTrait;

class Entrant extends Model
{
    use HasFactory;

	// Define the page size for the search results
	const PAGINATION_SIZE = 25;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'race_id',
		'rider_id',
		'place',
    ];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'race_id',
		'rider_id',
		'place',
	];

	/**
	 * Ensures that the model is not timestamped.
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Get a validator for an incoming registration request.
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator()
	{
		$data = $this->attributesToArray();

		return Validator::make($data, [
			'entrantsId' => ['integer', 'min:1'], // primary key
			'race_id' => ['integer', 'min:1'], // required foreign key
			'rider_id' => ['integer', 'min:1'], // required foreign key
			'place' => ['required', 'integer', 'min:-1'],
		]);
	}

	/**
	 * Get the Race for the Entrant
	 */
	public function race()
	{
		return $this->belongsTo('App\Models\Race');
	}

	/**
	 * Get the Rider for the Entrant
	 */
	public function rider()
	{
		return $this->belongsTo('App\Models\Rider');
	}

	/**
	 * Gets the number of entrants to a race of specified ID
	 */
	public static function getNumberEntrants($raceId)
	{
		return self::select('id')
			->where('race_id', $raceId, 'and')
			->count();
	}

	/**
	 * Gets the number of entrants to a race of specified ID
	 */
	public static function getPlacings($raceId, $limit = NULL)
	{
		return self::where('race_id', $raceId, 'and')
			// If applicable, add where condition for status
			->when(!empty($limit), function($query) use($limit) {
				return $query->limit($limit);
			})
			->orderBy('place', 'asc')
			->get();
	}

}
