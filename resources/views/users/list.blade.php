<?php
/**
 * List view
 * @note Default action for RiderController
 */
?>
@extends('layouts.app')

@section('title') {{'Users'}} @endsection

@section('content')

<div class="content-container">
	@if ( Session::has('success') )
		<p class="alert alert-success">{{ Session::get('success') }}</p>
	@endif

	@if ( Session::has('error') || $errors->any() )
		<p class="alert alert-error">{{ Session::get('error') }}</p>
	@endif

	<h1>Riders</h1>

	<div class="button"><a href="{{ route('/users/create') }}">Create Account</a></div>

	@include('users._search', [
		'user' => $user,
		'keyword' => $keyword,
		'role' => $role,
		'status' => $status,
		'clubsId' => $clubsId,
		'clubs' => App\Models\Club::get(),
	])

	<div id="usersList" class="users-list list-container">


	@if ( isset($users) )

		<div class="list-items">
			<div class="list-item list-header">
				<div class="name list-field">Name</div>
				<div class="email list-field">Email</div>
				<div class="organisation list-field">Organisation</div>
				<div class="role list-field">Role</div>
				<div class="status list-field">Status</div>
				<div class="actions list-field">&nbsp;</div>
			</div>

		@foreach ( $users as $user )

			<div class="list-item">
				<div class="name list-field">{{ $user->getFullName() }}</div>
				<div class="email list-field">{{ $user->email }}</div>
				<div class="organisation list-field">{{ $user->organisation }}</div>
				<div class="role list-field">{{ $user->getRole($user->role) }}</div>
				<div class="status list-field">{{ $user->getStatus($user->status) }}</div>
				<div class="actions list-field"><a href="{{ route('/users/update', $user->id) }}">Update</a></div>
			</div>

		@endforeach

		</div>

	@else

		<p>No users exist.</p>

	@endif

	</div>
</div>

@endsection
