<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use View;

class UsersController extends Controller
{
	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware(['auth', 'isAdmin']);
	}

	/**
	 * Show the list of available users
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request  )
	{
		$user = new \App\Models\User;

		$displayed = false;
		$keyword = $request->input('keyword');
		$role = $request->input('role');
		$status = $request->input('status');
		$clubsId = $request->input('club_id');
		$appends = ['keyword' => $keyword, 'role' => $role, 'status' => $status, 'clubsId' => $clubsId];

		if ( $request->isMethod('post') )
		{
			if ( !empty($keyword) || !empty($role) || !empty($status) )
			{
				$users = $user->search($keyword, $role, $status, $clubsId);
				$displayed = true;
			}
		}

		if ( !$displayed )
		{
			$users = $user->paginate($user::PAGINATION_SIZE);
		}

		$users->appends($appends);

		if ( count($users) > 0 )
		{
			$rv = view('users.list')->with([
				'users' => $users,
				'user' => $user,
				'keyword' => $keyword,
				'role' => $role,
				'status' => $status,
				'clubsId' => $clubsId
			]);
		}
		else
		{
			$rv = view('users.nonesuch')->with([
				'user' => $user,
				'keyword' => $keyword,
				'role' => $role,
				'status' => $status,
				'clubsId' => $clubsId
			]);
		}
		return $rv;
	}


	/**
	 * Show the form for creating a new user.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create( Request $request )
	{
		$user = new \App\Models\User;

		if ( $request->isMethod('post') )
		{
			$data = $request->get('User');
			$user->fillAttributesSafely($data);
			$rv = $user->storeDetails($request);
		}
		else
		{
			$rv = view('users.details')->with([
				'user' => $user,
				'label' => 'users',
				'route' => route('/users/create'),
				'limited' => false,
				'create' => true,
			]);
		}
		return $rv;
	}

	/**
	 * Updates the details of the user of specified $id
	 * @param integer $id The ID of the user to be updated
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update( $id, Request $request )
	{
		$user = \App\Models\User::findOrFail($id);

		if ( $request->isMethod('post') )
		{
			$data = $request->get('User');
			$user->fillAttributesSafely($data);
			$rv = $user->storeDetails($request);
		}
		else
		{
			$rv = view('users.details')->with([
				'user' => $user,
				'label' => 'users',
				'route' => route('/users/update', $user->id),
				'limited' => false,
				'create' => false,
			]);
		}
		return $rv;
	}

	/**
	 * Updates the password of the user of specified $id
	 * @param integer $id The ID of the user to be updated
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function password( Request $request )
	{
		$user = \App\Models\User::findOrFail($id);

		$saved = false;
		if ( $request->isMethod('post') )
		{
			if ( !empty($request->input('password')) )
			{
				$user->password = Hash::make($request->input('password'));

				$user->save();
				$saved = true;

				$rv = redirect('/users/list')->with('success', 'Password was successfully updated');
			}

		}

		if ( !$saved )
		{
			$rv = view('users.password')->with([
				'user' => $user,
				'label' => 'users',
				'route' => route('/users/password', $user->id)
			]);
		}
		return $rv;
	}

	/**
	 * Handles deleting the selected user.
	 * @note Deleted users are not removed from the database and only have the status set to 'inactive'
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete( Request $request )
	{
		$user = \App\Models\User::findOrFail($id);

		if ( $request->isMethod('post') )
		{
			$user->status = self::STATUS_INACTIVE;
			$user->save();

			$rv = redirect('/')->with('success', 'The user account was successfully deleted');
		}
		else
		{
			$rv = view('users.details')->with([
				'user' => $user,
				'label' => 'users',
				'route' => route('/users/update', $user->id),
				'limited' => false,
			]);
		}

		return $rv;
	}

}
