<?php
/**
 * Form view to allow user to change their password
 */
?>
@extends('layouts.app')

@section('title') {{'Change Password'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

		@if ( Session::has('success') )
			<p class="alert alert-success">{{ Session::get('success') }}</p>
		@endif

		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured changing your password. {{ Session::get('error') }}</p>
		@endif

		<h1>Change Password</h1>

		<form method="post" action="{{ $route }}">
			@csrf

			<div class="form-element">
				@if ($errors->has('password'))
					<div class="validation-error">{{ $errors->first('password') }}</div>
				@endif

				<label>Enter {{ $label }} password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password" value="" class="field {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('password_confirmation'))
					<div class="validation-error">{{ $errors->first('password_confirmation') }}</div>
				@endif

				<label>Re-enter {{ $label }} password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password_confirmation" value="" class="field {{ $errors->has('password_confirmation') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Save" class="button submit save" /></div>
			</div>

		</form>
	</div>
</div>

@endsection
