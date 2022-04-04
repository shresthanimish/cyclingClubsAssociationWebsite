<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DateTime;
use View;

class RaceController extends PublicController
{

	/**
	 * Show the list of available Race
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
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
			$races = $race->paginate();
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
		return $rv;
	}

	/**
	 * Show the form for creating a new resource.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function create( Request $request )
	{
		$rv = NULL;

		$race = new \App\Models\Race;

		if ( $request->isMethod('post') )
		{
			$data = $request->get('Race');
			Race::fillFromFilteredData($race, $data);

			$rv = $race->storeDetails($request);
		}

		if ( $rv === NULL )
		{
			$data = $request->session()->get('_old_input');
			if ( isset($data['Race']) && is_array($data['Race']) )
			{
				Race::fillFromFilteredData($race, $data['Race']);
			}

			$rv = view('races.details')->with([
				'race' => $race,
				'route' => route('/races/create')
			]);
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
		$race = \App\Models\Race::findOrFail($id);

		if ( $request->isMethod('post') )
		{
			$data = $request->get('Race');
			Race::fillFromFilteredData($race, $data);

			$rv = $race->storeDetails($request);
		}
		else
		{
			$data = $request->session()->get('_old_input');
			if ( isset($data['Race']) && is_array($data['Race']) )
			{
				Race::fillFromFilteredData($race, $data['Race']);
			}
			$rv = view('races.details')->with([
				'race' => $race,
				'route' => route('/races/details', $race->id)
			]);
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
	}

	/**
	 * Handles deleting a Race.
	 * @param integer $id The ID of the race to be deleted
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete( $id, Request $request )
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

		return $rv;
	}

}
