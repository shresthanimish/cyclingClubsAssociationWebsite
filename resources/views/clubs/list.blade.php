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
		'states' => App\Models\State::orderBy('name', 'asc')->get(),
		'statesId' => $statesId,
	])

	@include('clubs._list', [
		'clubs' => $clubs,
		'isAdmin' => true,
	])

	</div>
</div>

@endsection
