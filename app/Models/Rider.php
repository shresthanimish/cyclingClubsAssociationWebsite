<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Rider extends Model
{
    use HasFactory;

	// Define the gender options as constants
	const GENDER_FEMALE = 'female';
	const GENDER_MALE = 'male';
	const GENDER_OTHER = 'other';

	// Define the grading limits as constants
	const AGE_LOWER = 10;
	const AGE_UPPER = 120;

	// Define the grading limits as constants
	const GRADING_LOWER = 1;
	const GRADING_UPPER = 10;

	// Define the page size for the search results
	const PAGINATION_SIZE = 25;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'grading',
		'age',
		'gender',
		'club_id',
	];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'user_id',
		'grading',
		'age',
		'gender',
		'club_id',
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
			'user_id' => ['required', 'integer', 'min:1'], // required foreign key
			'grading' => ['required', 'numeric', 'min:' . self::GRADING_LOWER, 'max:' . self::GRADING_UPPER],
			'age' => ['required', 'numeric', 'min:' . self::AGE_LOWER, 'max:' . self::AGE_UPPER],
			'gender' => ['required', Rule::in([self::GENDER_MALE, self::GENDER_MALE, self::GENDER_OTHER])],
			'club_id' => ['required', 'integer', 'min:1'], // required foreign key
		]);
	}

	/**
	 * Get the User for the Rider
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
	/**
	 * Get the Club for the Rider
	 */
	public function club()
	{
		return $this->belongsTo('App\Models\Club');
	}


	/**
	 * Get the race entrants the rider was an entrant of.
	 */
	public function raceEntries()
	{
		return $this->hasMany('App\Models\Entrant');
	}

	/**
	 * Store details for a Rider
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
			if ( $this->save() )
			{
				$rv = redirect(route('/riders/index'))->with('success', 'Details for the rider were successfully saved');
			}
			else
			{
				$route = route('/riders/' . ( empty($this->id) ? 'create/' : 'details/' . $this->id ));
				$rv = redirect(route($route))->with('error', 'An error occured saving details for the rider.');
			}
		}

		return $rv;
	}

	/**
	 * Get the set of Riders that match the specified search term
	 * @param string $keyword
	 * @param string|NULL $gender
	 * @param string|NULL $clubsId
	 * @return Rider[]
	 */
	public function search( $keyword, $gender, $clubsId )
	{
		if ( !empty($keyword) || !empty($gender) || !empty($clubsId) )
		{
			$whereConditions = [];
			$table = $this->getTable();
			// Prepare array of search to generic filter fields as 'OR' joins
			if ( !empty($keyword) )
			{
				// Add where clauses for the generic fields as 'OR' joins
				$fieldsToSearch = ['first_name', 'surname', 'grading', 'age'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = [$table . '.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}

				// Add where clauses for the generic fields as 'OR' joins for the relation User
				$fieldsToSearch = ['title', 'address', 'suburb', 'postcode'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = ['users.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}
			}

			$joinTables = ( count($whereConditions) ? true : false );
			$rv = self::select($table . '.*')
				->where($whereConditions)
				// If applicable, add where condition for Club ID
				->when(!empty($clubsId), function($query) use($table, $clubsId) {
					return $query->where([
						[$table . '.club_id', '=', addslashes($clubsId), 'and']
					]);
				})
				// If applicable, add where condition for gender
				->when(!empty($gender), function($query) use($table, $gender) {
					return $query->where([
						[$table . '.gender', '=', addslashes($gender), 'and']
					]);
				})
				// If applicable, add the required joins to relations
				->when($joinTables, function($query) use ($table) {
					return $query->leftJoin('clubs', 'clubs.id', '=', $table . '.club_id');
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
	 * Gets the names for the available gender field enum options
	 * @return array Gets the names for the available gender field enum options
	 */
	public static function getGenderOptions()
	{
		return array(
			self::GENDER_FEMALE => 'Female',
			self::GENDER_MALE => 'Male',
			self::GENDER_OTHER => 'Other',
		);
	}

	/**
	 * Gets the name for the specified gender enum value
	 * @param string $gender The name for the gender
	 * @return string
	 */
	public static function getGenderText( $gender )
	{
		$options = self::getGenderOptions();
		return ( isset($options[$gender]) ? $options[$gender] : '' );
	}

	/**
	 * Gets the literal name for the gender attribute value stored for this race
	 * @return string
	 */
	public function getGender()
	{
		return self::getGenderText($this->gender);
	}

	/**
	 * Gets the ages available to a rider
	 * @return array Gets the ages available to a rider
	 */
	public static function getAgeOptions()
	{
		$rv = array();
		for ( $ageCnt = self::AGE_LOWER; $ageCnt <= self::AGE_UPPER; $ageCnt++ )
		{
			$rv[$ageCnt] = $ageCnt;
		}
		return $rv;
	}

	/**
	 * Gets the gradings available to a rider
	 * @return array Gets the gradings available to a rider
	 */
	public static function getGradingOptions()
	{
		$rv = array();
		for ( $gradeCnt = self::GRADING_LOWER; $gradeCnt <= self::GRADING_UPPER; $gradeCnt++ )
		{
			$rv[$gradeCnt] = $gradeCnt;
		}
		return $rv;
	}

}
