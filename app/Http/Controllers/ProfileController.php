<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Validator;
use View;

class ProfileController extends Controller
{
	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Allows the logged in user to update their details
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function details( Request $request )
	{
		$user = Auth::user();

		if ( $request->isMethod('post') )
		{
			$rv = $user->storeDetails($request);
		}
		else
		{
			$rv = view('users.details')->with([
				'user' => $user,
				'label' => 'your',
				'route' => route('/profile/details'),
				'limited' => true,
				'create' => false,
			]);
		}
		return $rv;
	}

	/**
	 * Allows the logged in user to update their password
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function password( Request $request )
	{
		$user = Auth::user();

		$saved = false;
		if ( $request->isMethod('post') )
		{
			if ( !empty($request->input('password')) )
			{
				$user->password = Hash::make($request->input('password'));
				$user->save();
				$saved = true;

				$rv = redirect('/dashboard')->with('success', 'Password was successfully updated');
			}
		}
		else
		{
			$rv = view('users.password')->with([
				'user' => $user,
				'label' => 'your new',
				'route' => route('/profile/password')
			]);
		}
		return $rv;
	}

	/**
	 * Allows the logged in user to update their details
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete( Request $request )
	{
		$user = Auth::user();

		$user->status = self::$STATUS_ACTIVE;
		$user->save();

		return redirect('/dashboard')->with('success', 'Your account was successfully deleted');
	}

}
