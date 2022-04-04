<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DateTime;
use View;

class RiderController extends PublicController
{

	/**
	 * Show the list of available Riders
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
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
			$riders = $rider->paginate();
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

		$rider = new \App\Models\Rider;

		if ( $request->isMethod('post') )
		{
			$data = $request->get('Rider');
			Rider::fillFromFilteredData($rider, $data);

			$rv = $rider->storeDetails($request);
		}

		if ( $rv === NULL )
		{
			$data = $request->session()->get('_old_input');
			if ( isset($data['Rider']) && is_array($data['Rider']) )
			{
				Rider::fillFromFilteredData($rider, $data['Rider']);
			}

			$rv = view('riders.details')->with([
				'rider' => $rider,
				'route' => route('/riders/create')
			]);
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
		$rider = \App\Models\Rider::findOrFail($id);

		if ( $request->isMethod('post') )
		{
			$data = $request->get('Rider');
			Rider::fillFromFilteredData($rider, $data);

			$rv = $rider->storeDetails($request);
		}
		else
		{
			$data = $request->session()->get('_old_input');
			if ( isset($data['Rider']) && is_array($data['Rider']) )
			{
				Rider::fillFromFilteredData($rider, $data['Rider']);
			}

			$rv = view('riders.details')->with([
				'rider' => $rider,
				'route' => route('/riders/details', $rider->id)
			]);
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

		return $rv;
	}

}
