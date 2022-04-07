<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showRegistrationForm()
	{
		return view('auth.register');
	}

	/**
	 * Get a validator for an incoming registration request.
	 * @param array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'first_name' => 'alpha_dash',
			'surname' => 'alpha_dash',
			'email' => ['required', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'min:6', 'max:30', 'confirmed'],
			'password_confirmation' => ['required', 'same:password'],
			'club_id' => ['integer', 'nullable', 'max:100'],
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 * @param array $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{
		return User::create([
			'first_name' => $data['first_name'],
			'surname' => $data['surname'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
			'role' => \App\Models\User::ROLE_RIDER,
			'club_id' => $data['clubsId'],
			'createdAt' => now()
		]);
	}

}
