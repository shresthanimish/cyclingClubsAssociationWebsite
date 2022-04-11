<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Models\Race;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RaceController extends PublicController
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
	 * Show the list of available Race
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$race = new \App\Models\Race;

			$searched = false;
			$keyword = $request->input('keyword');
			$clubsId = $request->input('clubsId');
			$statesId = $request->input('statesId');
			$status = $request->input('status');
			$appends = ['keyword' => $keyword, 'clubsId' => $clubsId, 'statesId' => $statesId, 'status' => $status];

			if ( $request->isMethod('post') )
			{
				if ( !empty($keyword ) || !empty($clubsId) || !empty($statesId) || !empty($status) )
				{
					$searched = true;
					$races = $race->search($keyword, $clubsId, $statesId, $status);
				}
			}

			// If we haven't searched get all items as a paginated set
			if ( !$searched )
			{
				$races = $race->paginate(Race::PAGINATION_SIZE);
			}

			if ( count($races) > 0 )
			{
				$races->appends($appends);
				$rv = view('races.list')->with([
					'races' => $races,
					'race' => $race,
					'keyword' => $keyword,
					'clubsId' => $clubsId,
					'statesId' => $statesId,
					'status' => $status,

				]);
			}
			else
			{
				$rv = view('races.nonesuch')->with([
					'race' => $race,
					'keyword' => $keyword,
					'clubsId' => $clubsId,
					'statesId' => $statesId,
					'status' => $status,
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

			$race = new \App\Models\Race;

			if ( $request->isMethod('post') )
			{
				$data = $request->get('Race');
				\App\Helpers\Utilities::fillFromFilteredData($race, $data);

				$rv = $race->storeDetails();
			}

			if ( $rv === NULL )
			{
				$rv = view('races.details')->with([
					'race' => $race,
					'route' => route('/races/create')
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
	 * Updates the details of the Race of specified $id
	 * @param integer $id The ID of the Race to be updated
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function details( $id, Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$race = \App\Models\Race::findOrFail($id);

			if ( $request->isMethod('post') )
			{
				$data = $request->get('Race');
				\App\Helpers\Utilities::fillFromFilteredData($race, $data);

				$rv = $race->storeDetails();
			}
			else
			{
				$rv = view('races.details')->with([
					'race' => $race,
					'route' => route('/races/details', $race->id)
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
	 * Handles deleting a Race.
	 * @param integer $id The ID of the race to be deleted
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete( $id, Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$race = \App\Models\Race::findOrFail($id);

			$allowed = false;
			if ( $allowed && $race->save() )
			{
				$rv = redirect('/races/index')->with('success', 'The race was successfully deleted');
			}
			else
			{
				$rv = redirect('/races/index')->with('error', 'An error occurred in deleting the race.');
			}
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}

		return $rv;
	}

	/**
	 * Updates the details of the Race of specified $id
	 * @param integer $id The ID of the Race to be updated
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function entrants( $id, Request $request )
	{
		$race = \App\Models\Race::findOrFail($id);

		// TODO: Display entrants
	}

}
