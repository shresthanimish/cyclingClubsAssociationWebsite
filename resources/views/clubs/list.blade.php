<?php
/**
 * List view
 * @note Default action for ClubController
 */
?>
@extends('layouts.app')

@section('title') {{'Clubs'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

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

			<div class="club-items list-items">
				<div class="club-item row list-header list-item">
					<div class="title column">Title</div>
					<div class="address column">Address</div>
					<div class="suburb column">Suburb</div>
					<div class="postcode column">Postcode</div>
					<div class="state column">State</div>
					<div class="actions column align-right">&nbsp;</div>
				</div>

		@foreach ( $clubs as $club )

				<div class="club-item row list-item">
					<div class="first-name column">{{ $club->title }}</div>
					<div class="address column">{{ $club->address }}</div>
					<div class="suburb column">{{ $club->suburb }}</div>
					<div class="postcode column">{{ $club->postcode }}</div>
					<div class="state column">{{ ( isset($club->state) ? $club->state->name : 'n/a' ) }}</div>
					<div class="actions column align-right"><a href="{{ route('/clubs/details', $club->id) }}">View</a></div>
				</div>

		@endforeach

			</div>

		{{ $clubs->links('vendor.pagination.custom') }}
	@endif

	</div>
</div>

@endsection
