<?php
/**
 * No search results view
 */
?>
@extends('layouts.app')

@section('content')

<div class="content-container">
	<h1>Riders</h1>

	<div class="button"><a href="{{ route('/riders/create') }}">Create Rider</a></div>

@if ( $searched )
	@include('riders._search', [
		'rider' => $rider,
		'keyword' => $keyword,
		'gender' => $gender,
		'clubsId' => $clubsId,
	])
@endif

	<p class="error-message">No riders {{ ($searched ? 'matched your search criteria. Please try again.' : 'currently exist.' ) }}</p>

</div>

@endsection
