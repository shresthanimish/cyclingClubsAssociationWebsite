<?php
/**
 * Form view to allow an informal user to register for an account
 */
?>
@extends('layouts.app')

@section('title') {{'Register'}} @endsection

@section('content')

	<div class="content-container">

		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured processing your request. {{ Session::get('error') }}</p>
		@endif

		<h1>Register</h1>

		<form method="POST" action="{{ route('register') }}">
			@csrf

			<div class="form-element">
				@if ($errors->has('firstName'))
					<div class="validation-error">{{ $errors->first('firstName') }}</div>
				@endif

				<label>Enter your first name <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="firstName" value="{{ old('firstName') }}" class="field {{ $errors->has('firstName') ? ' invalid' : '' }}" required {{ ( \Request::route()->getName() == 'register' ? 'autofocus' : '' ) }} /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('lastName'))
					<div class="validation-error">{{ $errors->first('lastName') }}</div>
				@endif

				<label>Enter your last name <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="lastName" value="{{ old('lastName') }}" class="field {{ $errors->has('lastName') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('organisation'))
					<div class="validation-error">{{ $errors->first('organisation') }}</div>
				@endif

				<label>Enter your organisation</label>
				<div class="form-input"><input type="text" name="organisation" value="{{ old('organisation') }}" class="field {{ $errors->has('organisation') ? ' invalid' : '' }}" /></div>
			</div>

			<div class="form-element">
				@if ( $errors->has('email') )
					<div class="validation-error">{{ $errors->first('email') }}</div>
				@endif

				<label>Enter your {{ __('Email') }} <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="email" value="{{ old('email') }}" class="field {{ $errors->has('email') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ( $errors->has('password') )
					<div class="validation-error">{{ $errors->first('password') }}</div>
				@endif

				<label>Enter your {{ __('Password') }} <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password" value="" class="field {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>{{ __('Confirm Password') }} <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password_confirmation" value="" class="field {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Register" class="button submit" /></div>
			</div>
		</form>

	</div>


@endsection
