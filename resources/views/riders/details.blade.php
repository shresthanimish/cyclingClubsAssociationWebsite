<?php
/**
 * Update details for a Rider view
 */
?>
@extends('layouts.app')

@section('content')

	<div class="content-container">

		<h1>{{ ( !empty($rider->id) ? 'Update rider' : 'Create new rider' ) }}</h1>

@include('riders._form', [
	'rider' => $rider,
	'clubs' => App\Models\Club::get(),
	'states' => App\Models\State::get(),
	'errors' => $errors,
	'route' => $route
])

	</div>

	<div class="button back-button"><a href="{{ route('/riders/index') }}">Back to riders list</a></div>

@endsection
