@extends('layouts.app')

@section('title') {{'Dashboard'}} @endsection

@section('content')

	<div class="content-block container">
		<h1>Dashboard</h1>

		<p>Welcome {{ Auth::user()->getFullName() }}</p>

		<p>This is some sample code written by Robert Alfaro.</p>
	</div>

@endsection
