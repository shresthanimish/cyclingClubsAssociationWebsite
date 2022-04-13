<?php
namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use View;

class PublicController extends Controller
{

	/**
	 * Show the welcome page.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function index( Request $request )
	{
		return view('welcome');
	}

	/**
	 * Show the about us page.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function about( Request $request )
	{
		return view('about');
	}

	/**
	 * Show the clubs page.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function clubs( Request $request )
	{
		if ( $request->isMethod('post') )
		{
			$club = new \App\Models\Club;
			$keyword = $request->input('keyword');
			$statesId = $request->input('statesId');
			$appends = ['keyword' => $keyword, 'statesId' => $statesId];
			$clubs = $club->search($keyword, $statesId);
			$clubs->appends($appends);
		}
		else
		{
			$keyword = $statesId = $clubs = NULL;
		}
		return view('clubs', [
			'keyword' => $keyword,
			'statesId' => $statesId,
			'states' => \App\Models\State::orderBy('name', 'asc')->get(),
			'clubs' => $clubs,
		]);
	}

	/**
	 * Show the races page.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function races( Request $request )
	{
		$race = new \App\Models\Race;
		return view('races', [
			'upcomingRaces' => $race->getUpcomingRaces(),
			'recentRaces' => $race->getRecentlyRunRaces(),
		]);
	}

	/**
	 * Show the contact page.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function contact( Request $request )
	{
		return view('contact');
	}

	/**
	 * Show the dashboard page.
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function dashboard( Request $request )
	{
		$loggedInUser = Auth::user();
		if ( is_object($loggedInUser) )
		{
			$rv = view('dashboard');
		}
		else
		{
			$rv = redirect('/')->with('error', 'You do not have permissions to access this feature.');
		}
		return $rv;
	}

	/**
	 * Handle logging user out
	 */
	public function logout()
	{
		Auth::logout();
		return redirect()->route('/');
	}

}
