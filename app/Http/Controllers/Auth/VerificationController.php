<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/**
 * Handles email verification for a new registrated user. Emails may also be re-sent if initial email wasn't received
 */
class VerificationController extends Controller
{

	use EmailVerificationRequest;

	/**
	 * Where to redirect users after verification.
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');
	}
}
