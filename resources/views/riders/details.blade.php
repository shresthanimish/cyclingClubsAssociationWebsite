<?php
/**
 * Update details for a Rider view
 */
?>
@extends('layouts.app')

@section('title') {{'Riders'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

		<h1>{{ ( !empty($rider->id) ? 'Update rider' : 'Create new rider' ) }}</h1>

@include('riders._form', [
	'rider' => $rider,
	'user' => $user,
	'clubs' => App\Models\Club::orderBy('title', 'asc')->get(),
	'states' => App\Models\State::orderBy('name', 'asc')->get(),
	'errors' => $errors,
	'route' => $route
])

		<div class="button back-button"><a href="{{ route('/riders/index') }}">Back to riders list</a></div>

	</div>
</div>

@endsection
