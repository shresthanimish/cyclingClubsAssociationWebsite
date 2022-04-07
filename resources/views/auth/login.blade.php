<?php
/**
 * Form view to allow a user to login
 */
?>
@extends('layouts.app')

@section('title') {{'Login'}} @endsection

@section('content')

	<div class="content-container">

		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured logging in to your account. {{ Session::get('error') }}</p>
		@endif

		<h1>Login to account</h1>

		<form method="post" action="{{ route('login') }}">
			@csrf

			<div class="form-element">
			@if ( $errors->has('email') )
				<div class="validation-error">{{ $errors->first('email') }}</div>
			@endif

				<label>Enter your email <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="email" value="{{ old('email') }}" class="input {{ $errors->has('email') ? ' invalid' : '' }}" required {{ ( \Request::route()->getName() == 'login' ? 'autofocus' : '' ) }} /></div>
			</div>

			<div class="form-element">
			@if ( $errors->has('password') )
				<div class="validation-error">{{ $errors->first('password') }}</div>
			@endif

				<label>Enter your password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password" value="" class="input {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Login" class="button submit" /></div>
			</div>

		</form>

		@if (Route::has('password.request'))
			<p><a href="{{ route('password.request') }}">Forgot Your Password?</a></p>
		@endif

	</div>


@endsection
