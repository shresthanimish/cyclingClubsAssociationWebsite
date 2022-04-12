<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
	use HasFactory;

	/**
	 * The database table used by the model.
	 * @var string
	 */
	protected $table = 'contact_form_submissions';

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	public $fillable = [
		'name',
		'email',
		'phone',
		'subject',
		'message'
	];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'name',
		'email',
		'phone',
		'subject',
		'message'
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
	public function validator()
	{
		$data = $this->attributesToArray();

		return Validator::make($data, [
			'id' => ['integer', 'min:1'], // primary key
			'name' => ['required', 'string', 'max:150'],
			'email' => ['required', 'email', 'max:255'],
			'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8', 'max:12'],
			'subject'=> ['required', 'string', 'max:255'],
			'message' => ['required', 'string', 'max:1000'],
        ]);
	}

}
