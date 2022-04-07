<?php
/**
 * List view
 * @note Default action for RaceController
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

	<h1>Races</h1>

	<div class="button"><a href="{{ route('/races/create') }}">Create Race</a></div>

@include('races._search', [
	'race' => $race,
	'keyword' => $keyword,
	'clubsId' => $clubsId,
	'statesId' => $statesId,
	'status' => $status,
])

	<div id="racesList" class="races-list list-container">

@if ( isset($races) && count($races) )

		<div class="list-items">
			<div class="rider-item list-header list-item">
				<div class="title list-field">Title</div>
				<div class="race-date list-field">Race Date</div>
				<div class="start-time list-field">Start Time</div>
				<div class="address list-field">Address</div>
				<div class="suburb list-field">Suburb</div>
				<div class="postcode list-field">Postcode</div>
				<div class="state list-field">State</div>
				<div class="status list-field">Status</div>
				<div class="actions list-field">&nbsp;</div>
			</div>

	@foreach ( $races as $race )

			<div class="rider-item list-item">
				<div class="title list-field">{{ $race->title }}</div>
				<div class="race-date list-field">{{ $race->getRaceDate() }}</div>
				<div class="start-time list-field">{{ $race->start_time }}</div>
				<div class="address list-field">{{ $race->address }}</div>
				<div class="suburb list-field">{{ $race->suburb }}</div>
				<div class="postcode list-field">{{ $race->postcode }}</div>
				<div class="state list-field">{{ ( isset($race->state) ? $race->state->name : 'n/a' ) }}</div>
				<div class="status list-field">{{ $race->getStatus() }}</div>
				<div class="actions list-field"><a href="{{ route('/races/details', $race->id) }}">View</a></div>
			</div>

	@endforeach

		</div>
@else

		<p>No races exist.</p>

@endif

	</div>
</div>

@endsection
