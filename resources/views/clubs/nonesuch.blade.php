<?php
/**
 * No search results view
 */
?>
@extends('layouts.app')

@section('title') {{'Clubs'}} @endsection

@section('content')

<div class="content-container">
	<h1>Clubs</h1>

	<div class="button"><a href="{{ route('/clubs/create') }}">Create Club</a></div>

@if ( $searched )
	@include('clubs._search', [
		'club' => $club,
		'keyword' => $keyword,
		'statesId' => $statesId,
	])
@endif

	<p class="error-message">No clubs {{ ($searched ? 'matched your search criteria. Please try again.' : 'currently exist.' ) }}</p>

</div>

@endsection
