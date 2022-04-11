<?php
/**
 * List view
 * @note Default action for RiderController
 */
?>
@extends('layouts.app')

@section('title') {{'Riders'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">{{ Session::get('error') }}</p>
		@endif

		<h1>Riders</h1>

		<div class="button"><a href="{{ route('/riders/create') }}">Create Rider</a></div>

		@include('riders._search', [
			'rider' => $rider,
			'keyword' => $keyword,
			'gender' => $gender,
			'clubsId' => $clubsId,
			'clubs' => App\Models\Club::get(),
		])

		<div id="ridersList" class="riders-list list-container">

		@if ( isset($riders) && count($riders) )

			<div class="rider-items list-items">
				<div class="rider-item row list-header list-item">
					<div class="first-name column">First Name</div>
					<div class="surname column">Surname</div>
					<div class="grading column">Grading</div>
					<div class="age column">Age</div>
					<div class="gender column">Gender</div>
					<div class="club column">Club</div>
					<div class="actions column align-right">&nbsp;</div>
				</div>

			@foreach ( $riders as $rider )

				<div class="rider-item row list-item">
					<div class="first-name column">{{ isset($rider->user) ? $rider->user->first_name : 'n/a' }}</div>
					<div class="last-name column">{{ isset($rider->user) ? $rider->user->surname : 'n/a' }}</div>
					<div class="grading column">{{ $rider->grading }}</div>
					<div class="age column">{{ $rider->age }}</div>
					<div class="gender column">{{ $rider->getGender() }}</div>
					<div class="club column">{{ ( isset($rider->user) && isset($rider->user->club) ? $rider->user->club->title : 'n/a' ) }}</div>
					<div class="actions column align-right"><a href="{{ route('/riders/details', $rider->id) }}">View</a></div>
				</div>

			@endforeach

			</div>

			{{ $riders->links('vendor.pagination.custom') }}
		@endif

	</div>
</div>

@endsection
