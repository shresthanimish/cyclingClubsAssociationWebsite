<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;

/**
 * Handles registration of new users and authentication of existing users
 */
class AuthController extends Controller
{

	/**
	 * Where to redirect users after login / registration.
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new authentication controller instance.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Get a validator for an incoming registration request.
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'firstName' => 'required|max:100',
			'lastName' => 'required|max:100',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		return User::create([
			'firstName' => $data['firstName'],
			'lastName' => $data['lastName'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
	}
}
