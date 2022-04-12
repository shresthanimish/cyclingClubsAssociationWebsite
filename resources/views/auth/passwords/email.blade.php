<?php
/**
 * Form view to allow a user to initiate the reset password process
 */
?>
@extends('layouts.app')

@section('title') {{'Reset Password'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

	@if ( session('status') )
		<div class="alert alert-success" role="alert">
			{{ session('status') }}
		</div>
	@endif

		<h1>Reset Password</h1>

		<form method="post" action="{{ route('password.email') }}">
			@csrf

			<div class="form-element">
			@if ($errors->has('email'))
				<div class="validation-error">{{ $errors->first('email') }}</div>
			@endif

				<label>Enter your email <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="email" value="{{ old('email') }}" required autofocus class="input {{ $errors->has('email') ? ' invalid' : '' }}" /></div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Send Password Reset Link" class="button submit" /></div>
			</div>

		</form>

	</div>
</div>

@endsection
