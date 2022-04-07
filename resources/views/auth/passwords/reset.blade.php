<?php
/**
 * Form view to allow a user to set their password in the reset password process
 */
?>
@extends('layouts.app')

@section('title') {{'Reset'}} @endsection

@section('content')

	<div class="content-container">
		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured processing your request. {{ Session::get('error') }}</p>
		@endif

		<h1>Reset Password</h1>

		<form method="post" action="{{ route('password.update') }}">
			<input type="hidden" name="token" value="{{ $token }}">
			@csrf

			<div class="form-element">
				@if ($errors->has('email'))
					<div class="validation-error">{{ $errors->first('email') }}</div>
				@endif

				<label>Enter your email <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="email" value="{{ old('email') }}" class="field {{ $errors->has('email') ? ' invalid' : '' }}" required autofocus /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('password'))
					<div class="validation-error">{{ $errors->first('password') }}</div>
				@endif

				<label>Enter your new password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password" value="" class="field {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('password_confirmation'))
					<div class="validation-error">{{ $errors->first('password_confirmation') }}</div>
				@endif

				<label>Re-enter your new password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password_confirmation" value="" class="field {{ $errors->has('password_confirmation') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Reset Password" class="button submit" /></div>
			</div>
		</form>
	</div>

@endsection
