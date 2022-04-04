<?php
/**
 * List view
 * @note Default action for RiderController
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

		<div class="list-items">
			<div class="rider-item list-header list-item">
				<div class="first-name list-field">First Name</div>
				<div class="surname list-field">Surname</div>
				<div class="grading list-field">Grading</div>
				<div class="age list-field">Age</div>
				<div class="gender list-field">Gender</div>
				<div class="club list-field">Club</div>
				<div class="actions list-field">&nbsp;</div>
			</div>

	@foreach ( $riders as $rider )

			<div class="rider-item list-item">
				<div class="first-name list-field">{{ $rider->first_name }}</div>
				<div class="last-name list-field">{{ $rider->surname }}</div>
				<div class="grading list-field">{{ $rider->grading }}</div>
				<div class="age list-field">{{ $rider->age }}</div>
				<div class="gender list-field">{{ $rider->getGender() }}</div>
				<div class="club list-field">{{ ( isset($rider->club) ? $rider->club->title : 'n/a' ) }}</div>
				<div class="actions list-field"><a href="{{ route('/riders/details', $rider->id) }}">View</a></div>
			</div>

	@endforeach

		</div>

@else

		<p>No riders exist.</p>

@endif

	</div>
</div>

@endsection
