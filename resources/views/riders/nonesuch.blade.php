<?php
/**
 * No search results or items exist view for a Rider
 */
?>
@extends('layouts.app')

@section('title') {{'Riders'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">
		<h1>Riders</h1>

		<div class="button"><a href="{{ route('/riders/create') }}">Create Rider</a></div>

		@if ( $searched )
			@include('riders._search', [
				'rider' => $rider,
				'keyword' => $keyword,
				'gender' => $gender,
				'clubsId' => $clubsId,
				'clubs' => App\Models\Club::get(),
			])
		@endif

		<p class="error-message">No riders {{ ($searched ? 'matched your search criteria. Please try again.' : 'currently exist.' ) }}</p>

	</div>
</div>

@endsection
