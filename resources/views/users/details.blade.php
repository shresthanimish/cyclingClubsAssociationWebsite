<?php
/**
 * Form view to allow either the logged in user to edit their account details or an admin to update the details of an existing.
 */
?>
@extends('layouts.app')

@section('title') {{'Users'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured saving {{ $label }} details. {{ Session::get('error') }}</p>
		@endif

		<h1>{{ ( !$create ? 'Update ' . $label . ' details' : 'Create new user' ) }}</h1>

@include('users._form', [
	'user' => $user,
	'label' => $label,
	'route' => $route,
	'limited' => $limited,
	'create' => $create,
	'clubs' => App\Models\Club::orderBy('title', 'asc')->get(),
	'errors' => $errors,
])

		<div class="button back-button"><a href="{{ route('/users/index') }}">Back to users list</a></div>

	</div>
</div>

@endsection
