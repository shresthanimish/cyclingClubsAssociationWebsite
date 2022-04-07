<?php
/**
 * Update details for a Race view
 */
?>
@extends('layouts.app')

@section('title') {{'Races'}} @endsection

@section('content')

	<div class="content-container">

	@if ( Session::has('success') )
		<p class="alert alert-success">{{ Session::get('success') }}</p>
	@endif

	@if ( Session::has('error') || $errors->any() )
		<p class="alert alert-error">{{ Session::get('error') }}</p>
	@endif

		<h1>{{ ( !empty($race->id) ? 'Update race' : 'Create new race' ) }}</h1>

@include('races._form', [
	'race' => $race,
	'clubs' => App\Models\Club::get(),
	'states' => App\Models\State::get(),
	'errors' => $errors,
	'route' => $route
])

	</div>

	<div class="button back-button"><a href="{{ route('/races/index') }}">Back to races list</a></div>

@endsection
