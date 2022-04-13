<?php
/**
 * List view
 * @note Default action for RiderController
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
			<p class="alert alert-error">{{ Session::get('error') }}</p>
		@endif

		<h1>Accounts</h1>

		<div class="button"><a href="{{ route('/users/create') }}">Create Account</a></div>

		@include('users._search', [
			'user' => $user,
			'keyword' => $keyword,
			'role' => $role,
			'status' => $status,
			'clubsId' => $clubsId,
			'clubs' => App\Models\Club::orderBy('title', 'asc')->get(),
		])

		<div id="usersList" class="users-list list-container">


		@if ( isset($users) )

			<div class="user-items list-items">
				<div class="user-item row list-item list-header">
					<div class="name column column-3">Name</div>
					<div class="email column column-5">Email</div>
					<div class="role column column-2">Role</div>
					<div class="role column column-2">Club</div>
					<div class="status column column-1">Status</div>
					<div class="actions column column-1 align-right">&nbsp;</div>
				</div>

			@foreach ( $users as $user )

				<div class="user-item row list-item">
					<div class="name column column-3">{{ $user->getFullName() }}</div>
					<div class="email column column-3">{{ $user->email }}</div>
					<div class="role column column-2">{{ $user->getRole($user->role) }}</div>
					<div class="role column column-2">{{ ( isset($user->club) ? $user->club->title : 'n/a' ) }}</div>
					<div class="status column column-1">{{ $user->getStatus($user->status) }}</div>
					<div class="actions column column-1 align-right"><a href="{{ route('/users/update', $user->id) }}">Update</a></div>
				</div>

			@endforeach

			</div>

			{{ $users->links('vendor.pagination.custom') }}
		@endif

		</div>
	</div>
</div>

@endsection
