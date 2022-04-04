<?php
/**
 * List view
 * @note Default action for ClubController
 */
?>
@extends('layouts.app')

@section('content')

<div class="content-container">
	@if ( Session::has('success') )
		<p class="alert alert-success">{{ Session::get('success') }}</p>
	@endif

	@if ( Session::has('error') || $errors->any() )
		<p class="alert alert-error">{{ Session::get('error') }}</p>
	@endif

	<h1>Clubs</h1>

	<div class="button"><a href="{{ route('/clubs/create') }}">Create Club</a></div>

@include('clubs._search', [
	'club' => $club,
	'keyword' => $keyword,
	'statesId' => $statesId,
])

	<div id="clubsList" class="clubs-list list-container">

@if ( isset($clubs) && count($clubs) )

		<div class="list-items">
			<div class="club-item list-header list-item">
				<div class="title list-field">Title</div>
				<div class="address list-field">Address</div>
				<div class="suburb list-field">Suburb</div>
				<div class="postcode list-field">Postcode</div>
				<div class="state list-field">State</div>
				<div class="actions list-field">&nbsp;</div>
			</div>

	@foreach ( $clubs as $club )

			<div class="club-item list-item">
				<div class="first-name list-field">{{ $club->title }}</div>
				<div class="address list-field">{{ $club->address }}</div>
				<div class="suburb list-field">{{ $club->suburb }}</div>
				<div class="postcode list-field">{{ $club->postcode }}</div>
				<div class="state list-field">{{ ( isset($club->state) ? $club->state->name : 'n/a' ) }}</div>
				<div class="actions list-field"><a href="{{ route('/clubs/details', $club->id) }}">View</a></div>
			</div>

	@endforeach

		</div>

@else

		<p>No clubs exist.</p>

@endif

	</div>
</div>

@endsection
