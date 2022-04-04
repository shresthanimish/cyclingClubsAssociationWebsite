<?php
/**
 * No search results view
 */
?>
@extends('layouts.app')

@section('content')

<div class="content-container">
	<h1>Races</h1>

	<div class="button"><a href="{{ route('/races/create') }}">Create Race</a></div>

@if ( $searched )
	@include('races._search', [
		'race' => $race,
		'keyword' => $keyword,
		'clubsId' => $clubsId,
		'statesId' => $statesId,
		'status' => $status,
	])
@endif

	<p class="error-message">No races {{ ($searched ? 'matched your search criteria. Please try again.' : 'currently exist.' ) }}</p>

</div>

@endsection
