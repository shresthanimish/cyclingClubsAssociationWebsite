<?php
/**
 * No search results or items exist view for a Rider
 */
?>
@extends('layouts.app')

@section('title') {{'Users'}} @endsection

@section('content')

	<div class="content-container">
		<h1>Accounts</h1>

		<div class="button"><a href="{{ route('/users/create') }}">Create User</a></div>

		@if ( $searched )
			@include('users.search', [
				'user' => $user,
				'keyword' => $keyword,
				'role' => $role,
				'status' => $status,
				'clubsId' => $clubsId,
				'clubs' => App\Models\Club::get(),
			])
		@endif

		<p class="error-message">No accounts {{ ($searched ? 'matched your search criteria. Please try again.' : 'currently exist.' ) }}</p>

	</div>

@endsection
