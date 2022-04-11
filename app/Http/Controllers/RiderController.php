<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Models\Rider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class RiderController extends PublicController
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
	 * Show the list of available Riders
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$rider = new \App\Models\Rider;

			$searched = false;
			$keyword = $request->input('keyword');
			$gender = $request->input('gender');
			$clubsId = $request->input('clubsId');
			$appends = ['keyword' => $keyword, 'gender' => $gender, 'clubsId' => $clubsId];

			if ( $request->isMethod('post') )
			{
				if ( !empty($keyword ) || !empty($gender) || !empty($clubsId) )
				{
					$searched = true;
					$riders = $rider->search($keyword, $gender, $clubsId);
				}
			}

			// If we haven't searched get all items as a paginated set
			if ( !$searched )
			{
				$riders = $rider->paginate($rider::PAGINATION_SIZE);
			}

			if ( count($riders) > 0 )
			{
				$riders->appends($appends);
				$rv = view('riders.list')->with([
					'riders' => $riders,
					'rider' => $rider,
					'keyword' => $keyword,
					'gender' => $gender,
					'clubsId' => $clubsId,
					'searched' => $searched,
				]);
			}
			else
			{
				$rv = view('riders.nonesuch')->with([
					'rider' => $rider,
					'keyword' => $keyword,
					'gender' => $gender,
					'clubsId' => $clubsId,
					'searched' => $searched,
				]);
			}
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}
		return $rv;
	}

	/**
	 * Show the form for creating a new resource.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create( Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$rv = NULL;

			$rider = new \App\Models\Rider;
			$user = new \App\Models\User;

			if ( $request->isMethod('post') )
			{
				$data = $request->get('Rider');
				\App\Helpers\Utilities::fillFromFilteredData($rider, $data);

				$data = $request->get('User');
				$user->fillAttributesSafely($data);

				$rv = $rider->storeDetails($user);
			}

			if ( $rv === NULL )
			{
				$rv = view('riders.details')->with([
					'rider' => $rider,
					'user' => $user,
					'route' => route('/riders/create'),
					'create' => true,
				]);
			}
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}
		return $rv;
	}

	/**
	 * Updates the details of the Rider of specified $id
	 * @param integer $id The ID of the Rider to be updated
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function details( $id, Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$rider = \App\Models\Rider::findOrFail($id);
			$user = \App\Models\User::findOrFail($rider->user_id);

			if ( $request->isMethod('post') )
			{
				$data = $request->get('Rider');
				\App\Helpers\Utilities::fillFromFilteredData($rider, $data);

				$data = $request->get('User');
				$user->fillAttributesSafely($data);

				$rv = $rider->storeDetails($user);
			}
			else
			{
				$rv = view('riders.details')->with([
					'rider' => $rider,
					'user' => $user,
					'route' => route('/riders/details', $rider->id),
					'create' => false,
				]);
			}
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}

		return $rv;
	}

	/**
	 * Handles deleting a Rider
	 * @param integer $id The ID of the Rider to be deleted
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete( $id, Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$rider = \App\Models\Rider::findOrFail($id);

			$allowed = false;
			if ( $allowed && $rider->delete() )
			{
				$rv = redirect('/riders/index')->with('success', 'The rider was successfully deleted');
			}
			else
			{
				$rv = redirect('/riders/index')->with('error', 'An error occurred deleting the rider.');
			}
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}

		return $rv;
	}

}
