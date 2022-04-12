<?php
namespace App\Models;

use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Traits\StatusTrait;

class User extends Model
{
	use HasApiTokens, HasFactory, Notifiable, Notifiable, StatusTrait;

	// Define the role options as constants
	const ROLE_ADMIN = 'admin';
	const ROLE_RIDER = 'rider';
	const ROLE_CLUB = 'club';

	// Define the page size for the search results
	const PAGINATION_SIZE = 25;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'first_name',
		'surname',
		'email',
		'password',
		'role',
		'club_id',
		'status',
		'email_verified_at',
		'created_at',
		'updated_at',
		'approved_at'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * The columns of the full text index
	 */
	protected $searchable = [
		'first_name',
		'surname',
		'email',
		'role',
		'club_id',
		'status',
	];

	/**
	 * Get a configured validator for validating the data in the model
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator()
	{
		$data = $this->attributesToArray();

		return Validator::make($data, [
			'id' => ['integer'], // primary key
			'first_name' => ['required', 'string', 'max:100'],
			'surname' => ['required', 'string', 'max:100'],
			'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->id, 'id')],
			'password' => ['min:6', 'max:30', 'confirmed'],
			'password_confirmation' => ['same:password'],
			'role' => [Rule::in([self::ROLE_ADMIN, self::ROLE_RIDER, self::ROLE_CLUB])],
			'club_id' => ['integer', 'min:1', 'nullable'], // required foreign key
			'status' => [Rule::in([self::$STATUS_ACTIVE, self::$STATUS_INACTIVE])],
			'remember_token' => ['string', 'nullable', 'max:100'],
		]);
	}

	/**
	 * Get the Club for the Rider
	 */
	public function club()
	{
		return $this->belongsTo('App\Models\Club');
	}

	/**
	 * Fill the attributes for the model safely with the specified data
	 * @param array $data
	 */
	public function fillAttributesSafely($data)
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == self::ROLE_ADMIN )
		{
			$attributeNames = ['first_name', 'surname', 'email', 'role', 'club_id', 'status'];
		}
		else
		{
			$attributeNames = ['first_name', 'surname', 'email'];
		}

		// Set the attributes the user is allowed to fill
		$parameterNames = array_keys($data);
		if ( is_array($parameterNames) )
		{
			$attributeNames = array_flip(array_intersect($attributeNames, $parameterNames));
		}
		$input = array_intersect_key($data, $attributeNames);
		$this->fill($input);

		// Hash the password (for new user)
		if ( !$this->exists )
		{
			$this->password = Hash::make('password');
		}
	}

	/**
	 * Store details for the user
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function storeDetails( Request $request )
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
				if ( strpos($request->path(), 'profile/') !== false )
				{
					$route = '/profile/details';
					$message = 'Your details were successfully updated';
				}
				else
				{
					$route = '/users/update/' . $this->usersId;
					$message = 'Details for user ' . $this->getFullName() . ' were successfully updated';
				}
				$rv = redirect($route)->with('success', $message);
			}
			else
			{
				$message = 'An error occured saving ' . ( strpos($request->path(), 'profile/') !== false ? 'your details.' : 'details for user.' );
				$rv = redirect($route)->with('error', $message);
			}
		}

		return $rv;
	}

	/**
	 * Get the set of users that match the specified search term
	 * @param string $keyword
	 * @param string|NULL $role
	 * @param string|NULL $status
	 * @param integer|NULL $clubsId
	 * @return User[]
	 */
	public function search( $keyword, $role = NULL, $status = NULL, $clubsId = NULL )
	{
		if ( !empty($keyword) || !empty($role) || !empty($roleRelationsId) || !empty($status) )
		{
			$whereConditions = [];
			$table = $this->getTable();
			// Prepare array of search to generic filter fields as 'OR' joins
			if ( !empty($keyword) )
			{
				// Add where clauses for the generic fields as 'OR' joins
				$fieldsToSearch = ['first_name', 'surname', 'email'];
				foreach ( $fieldsToSearch as $fieldname )
				{
					$whereConditions[] = [$table . '.' . $fieldname, 'like', '%' . addslashes($keyword) . '%', 'or'];
				}
			}

			$joinRiders = ( !empty($clubsId) ? true : false );
			$rv = self::select($table . '.*')
				->where($whereConditions)
				// If applicable, add where condition for gender
				->when(!empty($role), function($query) use($table, $role) {
					return $query->where([
						[$table . '.role', '=', addslashes($role), 'and']
					]);
				})
				// If applicable, add where condition for gender
				->when(!empty($status), function($query) use($table, $status) {
					return $query->where([
						[$table . '.status', '=', addslashes($status), 'and']
					]);
				})
				// If applicable, add the required joins to relations
				->when($joinRiders, function($query) use ($table) {
					return $query->join('riders', 'user_id', '=', $table . '.id')
						->where([
							['riders.club_id', '=', addslashes($clubsId), 'and']
						]);
				})
				->paginate(self::PAGINATION_SIZE);
		}
		else
		{
			$rv = self::paginate(self::PAGINATION_SIZE);
		}

		return $rv;	}

	/**
	 * Get the full name for the user
	 * @return string
	 */
	public function getFullName()
	{
		$name = '';
		if ( !empty($this->first_name) )
		{
			$name .= $this->first_name;
		}
		if ( !empty($this->surname) )
		{
			$name .= ' ' . $this->surname;
		}
		return $name;
	}

	/**
	 * Gets the names for the available role field values
	 * @return array Gets the names for the available role field values
	 */
	public static function getRoleOptions()
	{
		return array(
			self::ROLE_ADMIN => 'Administrator',
			self::ROLE_RIDER => 'Rider',
			self::ROLE_CLUB => 'Club',
		);
	}

	/**
	 * Gets the name of a Role value
	 * @param string $role The name for the role
	 * @return string
	 */
	public static function getRoleText( $role )
	{
		$roleOptions = self::getRoleOptions();
		return ( isset($roleOptions[$role]) ? $roleOptions[$role] : '' );
	}

	/**
	 * Gets the literal name for the Role enum value stored for this user
	 * @return string
	 */
	public function getRole()
	{
		return self::getRoleText($this->role);
	}

}
