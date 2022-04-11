<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Club extends Model
{
    use HasFactory;

	// Define the page size for the search results
	const PAGINATION_SIZE = 25;

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'title',
		'address',
		'suburb',
		'postcode',
		'state_id',
	];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'title',
		'address',
		'suburb',
		'postcode',
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
			'title' => ['required', 'string', 'max:100', Rule::unique('clubs')->ignore($this->id)],
			'address' => ['required', 'string', 'max:100'],
			'suburb' => ['required', 'string', 'max:50'],
			'postcode' => ['required', 'string', 'min:4', 'max:4'],
			'state_id' => ['required', 'integer', 'min:1'], // foreign key
		]);
	}

	/**
	 * Get the State for the UtilityEmission
	 */
	public function state()
	{
		return $this->belongsTo('App\Models\State');
	}

	/**
	 * Get the races for this club.
	 */
	public function races()
	{
		return $this->hasMany('App\Models\Race');
	}

	/**
	 * Get the riders for this club.
	 */
	public function riders()
	{
		return $this->hasMany('App\Models\Rider');
	}

	/**
	 * Store details for Club
	 * @return \Illuminate\Http\Response
	 */
	public function storeDetails()
	{
		$validator = $this->validator();
		if ( $validator->fails() )
		{
			$rv = back()
				->withInput()
				->withErrors($validator);
		}
		else
		{
			if ( $this->save() )
			{
				$rv = redirect(route('/clubs/index'))->with('success', 'Details for the club were successfully saved');
			}
			else
			{
				$route = route('/clubs/' . ( !$this->exists ? 'create/' : 'details/' . $this->id ));
				$rv = redirect(route($route))->with('error', 'An error occured saving details for the club.');
			}
		}

		return $rv;
	}

	/**
	 * Get the set of Clubs that match the specified search term
	 * @param string $keyword
	 * @param int|NULL $statesId
	 * @return Club[]
	 */
	public function search( $keyword, $statesId )
	{
		if ( !empty($keyword) || !empty($statesId) )
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

				// Add where clauses for the generic fields as 'OR' joins for the relation State
				$fieldsToSearch = ['name', 'abbreviation'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = ['states.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}
			}

			$joinTables = ( count($whereConditions) ? true : false );
			$rv = self::select($table . '.*')
				->where($whereConditions)
				// If applicable, add where condition for State ID
				->when(!empty($statesId), function($query) use($table, $statesId) {
					return $query->where([
						[$table . '.state_id', '=', addslashes($statesId), 'and']
					]);
				})
				// If applicable, add the required joins to relations
				->when($joinTables, function($query) use ($table) {
					return $query->leftJoin('states', 'states.id', '=', $table . '.state_id');
				})
				->paginate(self::PAGINATION_SIZE);
		}
		else
		{
			$rv = self::paginate(self::PAGINATION_SIZE);
		}

		return $rv;
	}

}
