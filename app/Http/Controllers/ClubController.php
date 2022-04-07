<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\Models\Club;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClubController extends PublicController
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
	 * Show the list of available Clubs
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$club = new \App\Models\Club;

			$searched = false;
			$keyword = $request->input('keyword');
			$statesId = $request->input('statesId');
			$appends = ['keyword' => $keyword, 'statesId' => $statesId];

			if ( $request->isMethod('post') )
			{
				if ( !empty($keyword ) || !empty($statesId) )
				{
					$searched = true;
					$clubs = $club->search($keyword, $statesId);
				}
			}

			// If we haven't searched get all items as a paginated set
			if ( !$searched )
			{
				$clubs = $club->paginate();
			}

			if ( count($clubs) > 0 )
			{
				$clubs->appends($appends);
				$rv = view('clubs.list')->with([
					'clubs' => $clubs,
					'club' => $club,
					'keyword' => $keyword,
					'statesId' => $statesId,
					'searched' => $searched,
				]);
			}
			else
			{
				$rv = view('clubs.nonesuch')->with([
					'club' => $club,
					'keyword' => $keyword,
					'statesId' => $statesId,
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
	 * Show the form for creating a new Club.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create( Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$rv = NULL;

			$club = new \App\Models\Club;

			if ( $request->isMethod('post') )
			{
				$data = $request->get('Club');
				Utilities::fillFromFilteredData($club, $data);

				$rv = $club->storeDetails($request);
			}

			if ( $rv === NULL )
			{
				$rv = view('clubs.details')->with([
					'club' => $club,
					'route' => route('/clubs/create')
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
	 * Updates the details of the Club of specified $id
	 * @param integer $id The ID of the Club to be updated
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function details( $id, Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$club = \App\Models\Club::findOrFail($id);

			if ( $request->isMethod('post') )
			{
				$data = $request->get('Club');
				Utilities::fillFromFilteredData($club, $data);

				$rv = $club->storeDetails($request);
			}
			else
			{
				$rv = view('clubs.details')->with([
					'club' => $club,
					'route' => route('/clubs/details', $club->id)
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
	 * Handles deleting a Club.
	 * @param integer $id The ID of the Club to be deleted
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete( $id, Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) && $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
		{
			$club = \App\Models\Club::findOrFail($id);

			$allowed = false;
			// TODO: Add check to protect club in use
			if ( $allowed && $club->delete() )
			{
				$rv = redirect('/clubs/index')->with('success', 'The club was successfully deleted');
			}
			else
			{
				$rv = redirect('/clubs/index')->with('error', 'An error occurred deleting the club.');
			}
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}

		return $rv;
	}

}
