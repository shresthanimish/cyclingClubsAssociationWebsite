<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class Race extends Model
{
	use HasFactory;

	// Define the status options as constants
	const STATUS_PENDING = 'pending';
	const STATUS_COMPLETE = 'complete';

	// Define the page size for the search results
	const PAGINATION_SIZE = 25;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'club_id',
		'title',
		'race_date',
		'start_time',
		'address',
		'suburb',
		'postcode',
		'state_id',
		'status'
  ];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'club_id',
		'title',
		'race_date',
		'start_time',
		'address',
		'suburb',
		'postcode',
		'state_id',
		'status'
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
			'id' => ['integer', 'min:1'], // primary key
			'club_id' => ['required', 'integer', 'min:1'], // required foreign key
			'title' => ['required', 'string', 'max:100',
				Rule::unique('races')->where(function ($query) {
					return $query->where('title', $this->title)->where('club_id', $this->club_id);
				})->ignore($this->id)
			],
			'race_date' => ['required', 'date_format:Y-m-d'],
			'start_time' => ['required', 'string', 'max:100'],
			'address' => ['required', 'string', 'max:100'],
			'suburb' => ['required', 'string', 'max:50'],
			'postcode' => ['required', 'string', 'min:4', 'max:4'],
			'state_id' => ['required', 'integer', 'min:1'], // foreign key
			'status' => ['required', Rule::in([self::STATUS_PENDING, self::STATUS_COMPLETE])],
		]);
	}

	/**
	 * Get the Club for the Race
	 */
	public function club()
	{
		return $this->belongsTo('App\Models\Club');
	}

	/**
	 * Get the State for the UtilityEmission
	 */
	public function state()
	{
		return $this->belongsTo('App\Models\State');
	}

	/**
	 * Get the race entrants for this race.
	 */
	public function raceEntrants()
	{
		return $this->hasMany('App\Models\Entrant');
	}

	/**
	 * Gets an array mapping a date field to the date format for a flight emission
	 * @return array
	 */
	public function getDateFields()
	{
		return [
			'race_date' => 'Y-m-d',
		];
	}

	/**
	 * Gets the formatted date for the race date using the specified date format string
	 * @param string $format
	 * @return string
	 */
	public function getRaceDate( $format = 'Y-m-d' )
	{
		if ( !empty($this->race_date) )
		{
			$date = new Carbon($this->race_date);
			$rv = $date->format($format);
		}
		else
		{
			$rv = NULL;
		}
		return $rv;
	}

	/**
	 * Gets the names for the available status field enum options
	 * @return array Gets the names for the available status field enum options
	 */
	public static function getStatusOptions()
	{
		return array(
			self::STATUS_PENDING => 'Pending',
			self::STATUS_COMPLETE => 'Complete',
		);
	}

	/**
	 * Gets the name for the specified status enum value
	 * @param string $status The name for the status
	 * @return string
	 */
	public static function getStatusText( $status )
	{
		$options = self::getStatusOptions();
		return ( isset($options[$status]) ? $options[$status] : '' );
	}

	/**
	 * Gets the literal name for the status attribute value stored for this race
	 * @return string
	 */
	public function getStatus()
	{
		return self::getStatusText($this->status);
	}

	/**
	 * Store details for a Race
	 * @return \Illuminate\Http\Response
	 */
	public function storeDetails()
	{
		$validator = $this->validator();
		if ( $validator->fails() )
		{
			$rv = back()->withErrors($validator)->withInput();
		}
		else
		{
			if ( $this->saveOrFail() )
			{
				$rv = redirect(route('/races/index'))->with('success', 'Details for the race were successfully saved');
			}
			else
			{
				$route = route('/races/' . ( !$this->exists ? 'create/' : 'details/' . $this->id ));
				$rv = redirect(route($route))->with('error', 'An error occured saving details for the race.');
			}
		}

		return $rv;
	}

	/**
	 * Get the set of Races that match the specified search term
	 * @param string $keyword
	 * @param int|NULL $clubsId
	 * @param int|NULL $statesId
	 * @param string|NULL $status
	 * @return Race[]
	 */
	public function search( $keyword = NULL, $clubsId = NULL, $statesId = NULL, $status = NULL )
	{
		if ( !empty($keyword) || !empty($clubsId) || !empty($statesId) || !empty($status) )
		{
			$whereConditions = [];
			$table = $this->getTable();
			// Prepare array of search to generic filter fields as 'OR' joins
			if ( !empty($keyword) )
			{
				// Add where clauses for the generic fields as 'OR' joins
				$fieldsToSearch = ['title', 'address', 'suburb', 'postcode'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = [$table . '.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}

				// Add where clauses for the generic fields as 'OR' joins for the relation Club
				$fieldsToSearch = ['title', 'address', 'suburb', 'postcode'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = ['clubs.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}

				// Add where clauses for the generic fields as 'OR' joins for the relation State
				$fieldsToSearch = ['name', 'abbreviation'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = ['states.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}
			}

			$hasWheres = ( count($whereConditions) ? true : false );
			$rv = self::select($table . '.*')
				// If applicable, add where condition for Club ID
				->when(!empty($clubsId), function($query) use($table, $clubsId) {
					return $query->where($table . '.club_id', '=', addslashes($clubsId), 'or');
				})
				// If applicable, add where condition for State ID
				->when(!empty($statesId), function($query) use($table, $statesId) {
					return $query->where($table . '.state_id', '=', addslashes($statesId));
				})
				// If applicable, add where condition for status
				->when(!empty($status), function($query) use($table, $status) {
					return $query->where($table . '.status', '=', addslashes($status), 'or');
				})
				// If applicable, add the required joins to relations
				->when($hasWheres, function($query) use ($table, $whereConditions) {
					return $query->leftJoin('clubs', 'clubs.id', '=', $table . '.club_id')
					->leftJoin('states', 'states.id', '=', $table . '.state_id')
					->where($whereConditions);
				})
				->paginate(self::PAGINATION_SIZE);
		}
		else
		{
			$rv = self::paginate(self::PAGINATION_SIZE);
		}

		return $rv;
	}

	/**
	 * Gets the upcoming races
	 */
	public function getUpcomingRaces()
	{
		$startDate = Carbon::now();
		$endDate = Carbon::now()->add(6, 'month');

		return self::where('status', self::STATUS_PENDING, 'and')
			->whereBetween('race_date', [$startDate, $endDate], 'and')
			->orderBy('race_date', 'asc')
			->get();
	}

	/**
	 * Gets the recently completed races
	 */
	public function getRecentlyRunRaces()
	{
		$startDate = Carbon::now()->sub(6, 'month');
		$endDate = Carbon::now();
		return self::where('status', self::STATUS_COMPLETE, 'and')
			->whereBetween('race_date', [$startDate, $endDate], 'and')
			->orderBy('race_date', 'asc')
			->get();
	}

}
