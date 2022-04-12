<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Rider;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Handles the registration of new users as well as their validation and creation.
 */
class RegisterController extends Controller
{

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 * @var string
	 */
	protected $redirectTo = '/dashboard';

	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application registration form.
	 * @return \Illuminate\Http\Response
	 */
	public function showRegistrationForm()
	{
		return view('auth.register', [
			'clubs' => \App\Models\Club::orderBy('title', 'asc')->get(),
			'gradingOptions' => Rider::getGradingOptions(),
			'ageOptions' => Rider::getAgeOptions(),
			'genderOptions' => Rider::getGenderOptions(),
		]);
	}

	/**
	 * Get a validator for an incoming registration request.
	 * @param array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'first_name' => ['required', 'string', 'max:100'],
			'surname' => ['required', 'string', 'max:100'],
			'email' => ['required', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'min:6', 'max:30', 'confirmed'],
			'password_confirmation' => ['required', 'same:password'],
			'grading' => ['required', 'numeric', 'min:' . Rider::GRADING_LOWER, 'max:' . Rider::GRADING_UPPER],
			'age' => ['required', 'numeric', 'min:' . Rider::AGE_LOWER, 'max:' . Rider::AGE_UPPER],
			'gender' => ['required', Rule::in([Rider::GENDER_FEMALE, Rider::GENDER_MALE, Rider::GENDER_OTHER])],
			'club_id' => ['required', 'integer', 'max:100'],
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 * @param array $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
		$user = User::create([
			'first_name' => $data['first_name'],
			'surname' => $data['surname'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
			'role' => User::ROLE_RIDER,
			'club_id' => $data['club_id'],
			'createdAt' => now()
		]);

		if ( !empty($user) && $user->exists )
		{
			$rider = new Rider;
			\App\Helpers\Utilities::fillFromFilteredData($rider, $data);
			$rider->user_id = $user->id;
			$rider->saveOrFail();
		}

		return $user;
	}

}
