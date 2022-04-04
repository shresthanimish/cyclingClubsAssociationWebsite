<?php
/**
 * Update details for a Race view
 */
?>
@extends('layouts.app')

@section('content')

	<div class="content-container">

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
