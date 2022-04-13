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
			'clubs' => App\Models\Club::orderBy('title', 'asc')->get(),
		])

		<div id="ridersList" class="riders-list list-container">

		@if ( isset($riders) && count($riders) )

			<div class="rider-items list-items">
				<div class="rider-item row list-header list-item">
					<div class="first-name column column-2">First Name</div>
					<div class="surname column column-3">Surname</div>
					<div class="grading column column-1">Grading</div>
					<div class="age column column-1">Age</div>
					<div class="gender column column-1">Gender</div>
					<div class="club column column-3">Club</div>
					<div class="actions column column-1 align-right">&nbsp;</div>
				</div>

			@foreach ( $riders as $rider )

				<div class="rider-item row list-item">
					<div class="first-name column column-2">{{ isset($rider->user) ? $rider->user->first_name : 'n/a' }}</div>
					<div class="last-name column column-3">{{ isset($rider->user) ? $rider->user->surname : 'n/a' }}</div>
					<div class="grading column column-1">{{ $rider->grading }}</div>
					<div class="age column column-1">{{ $rider->age }}</div>
					<div class="gender column column-1">{{ $rider->getGender() }}</div>
					<div class="club column column-3">{{ ( isset($rider->user) && isset($rider->user->club) ? $rider->user->club->title : 'n/a' ) }}</div>
					<div class="actions column column-1 align-right"><a href="{{ route('/riders/details', $rider->id) }}">View</a></div>
				</div>

			@endforeach

			</div>

			{{ $riders->links('vendor.pagination.custom') }}
		@endif

		</div>
	</div>
</div>

@endsection
