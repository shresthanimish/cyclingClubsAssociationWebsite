<?php
/**
 * List view
 * @note Default action for RaceController
 */
?>
@extends('layouts.app')

@section('title') {{'Races'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

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
		'clubs' => App\Models\Club::orderBy('title', 'asc')->get(),
		'clubsId' => $clubsId,
		'states' => App\Models\State::orderBy('name', 'asc')->get(),
		'statesId' => $statesId,
		'status' => $status,
	])

		<div id="racesList" class="races-list list-container">

	@if ( isset($races) && count($races) )

			<div class="race-items list-items">
				<div class="race-item row list-header list-item">
					<div class="title column column-2">Title</div>
					<div class="race-date column column-2">Race Date</div>
					<div class="address column column-2">Address</div>
					<div class="suburb column column-2">Suburb</div>
					<div class="postcode column column-1">Postcode</div>
					<div class="state column column-1">State</div>
					<div class="status column column-1">Status</div>
					<div class="actions column column-1 align-right">&nbsp;</div>
				</div>

		@foreach ( $races as $race )

				<div class="race-item row list-item">
					<div class="title column column-2">{{ $race->title }}</div>
					<div class="race-date column column-2">{{ $race->getRaceDate() }}<br />{{ $race->start_time }}</div>
					<div class="address column column-2">{{ $race->address }}</div>
					<div class="suburb column column-2">{{ $race->suburb }}</div>
					<div class="postcode column column-1">{{ $race->postcode }}</div>
					<div class="state column column-1">{{ ( isset($race->state) ? $race->state->name : 'n/a' ) }}</div>
					<div class="status column column-1">{{ $race->getStatus() }}</div>
					<div class="actions column column-1 align-right"><a href="{{ route('/races/details', $race->id) }}">View</a></div>
				</div>

		@endforeach

			</div>

		{{ $races->links('vendor.pagination.custom') }}
	@endif

		</div>
	</div>
</div>

@endsection
