<?php
namespace App\Http\Controllers;

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
}
