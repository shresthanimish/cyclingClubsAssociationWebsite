<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'name',
		'abbreviation'
	];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'name',
		'abbreviation'
	];

	/**
	 * Ensures that the model is not timestamped.
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Get a configured validator for validating the data in the model
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator()
	{
		$data = $this->attributesToArray();

		return Validator::make($data, [
			'id' => ['integer', 'min:1'], // primary key
			'name' => ['required', 'string', 'max:100', Rule::unique('states')->ignore($this->id)],
			'abbreviation' => ['required', 'string', 'max:10']
        ]);
	}

	/**
	 * Gets an array mapping the state ID to the state name
	 * @return array
	 */
	public function getOptionsData()
	{
		$rv = [];

		$builder = $this->select('id', 'name')
			->orderby('name', 'asc');

		$states = $builder->get();

		foreach ( $states as $state )
		{
			$rv[$state->id] = $state->name;
		}
		return $rv;
	}

}
