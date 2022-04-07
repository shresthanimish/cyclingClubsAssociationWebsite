<?php
/**
 * Update details for a Club view
 */
?>
@extends('layouts.app')

@section('title') {{'Clubs'}} @endsection

@section('content')

	<div class="content-container">

		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured processing your request. {{ Session::get('error') }}</p>
		@endif

		<h1>{{ ( !empty($club->id) ? 'Update club' : 'Create new club' ) }}</h1>

@include('clubs._form', [
	'club' => $club,
	'states' => App\Models\State::get(),
	'errors' => $errors,
	'route' => $route
])

	</div>

	<div class="button back-button"><a href="{{ route('/clubs/index') }}">Back to clubs list</a></div>

@endsection
