<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DateTime;
use View;

class ClubController extends PublicController
{

	/**
	 * Show the list of available Clubs
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
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
		return $rv;
	}


	/**
	 * Show the form for creating a new Club.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create( Request $request )
	{
		$rv = NULL;

		$club = new \App\Models\Club;

		if ( $request->isMethod('post') )
		{
			$data = $request->get('Club');
			Club::fillFromFilteredData($club, $data);

			$rv = $club->storeDetails($request);
		}

		if ( $rv === NULL )
		{
			$data = $request->session()->get('_old_input');
			if ( isset($data['Club']) && is_array($data['Club']) )
			{
				Club::fillFromFilteredData($club, $data['Club']);
			}

			$rv = view('clubs.details')->with([
				'club' => $club,
				'route' => route('/clubs/create')
			]);
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
		$club = \App\Models\Club::findOrFail($id);

		if ( $request->isMethod('post') )
		{
			$data = $request->get('Club');
			Club::fillFromFilteredData($club, $data);

			$rv = $club->storeDetails($request);
		}
		else
		{
			$data = $request->session()->get('_old_input');
			if ( isset($data['Club']) && is_array($data['Club']) )
			{
				Club::fillFromFilteredData($club, $data['Club']);
			}

			$rv = view('clubs.details')->with([
				'club' => $club,
				'route' => route('/clubs/details', $club->id)
			]);
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

		return $rv;
	}

}
