<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Handles password reset requests and uses a simple trait to include this behavior
 */
class ResetPasswordController extends Controller
{

	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
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
}
