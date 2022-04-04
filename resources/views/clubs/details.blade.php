<?php
/**
 * Update details for a Club view
 */
?>
@extends('layouts.app')

@section('content')

	<div class="content-container">

		<h1>{{ ( !empty($club->id) ? 'Update club' : 'Create new club' ) }}</h1>

@include('clubs._form', [
	'club' => $club,
	'states' => App\Models\State::get(),
	'errors' => $errors,
	'route' => $route
])

	</div>

	<div class="button back-button"><a href="{{ route('/clubs/index') }}">Back to clubs list</a></div>

@endsection
