<?php
/**
 * Form view to allow an informal user to register for an account
 */
?>
@extends('layouts.app')

@section('title') {{'Register'}} @endsection

@section('content')

<div class="admin content-block container pad-vertically">
	<div class="white-container">

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
				@if ($errors->has('club_id'))
					<div class="validation-error">{{ $errors->first('club_id') }}</div>
				@endif

				<label>Club <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@if ( is_object($clubs) && count($clubs) )
					<select name="club_id" required autofocus class="select {{ $errors->has('club_id') ? ' invalid' : '' }}">
					@foreach ( $clubs as $club )
						<option value="{{ $club->id }}" {{ ( $club->id == old('club_id') ? 'selected="true"' : '' ) }}>{{ $club->title }}</option>
					@endforeach
					</select>
				@endif
				</div>
			</div>

			<div class="form-element">
				@if ($errors->has('first_name'))
					<div class="validation-error">{{ $errors->first('first_name') }}</div>
				@endif

				<label>Enter your first name <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="first_name" value="{{ old('first_name') }}" class="input {{ $errors->has('first_name') ? ' invalid' : '' }}" required {{ ( \Request::route()->getName() == 'register' ? 'autofocus' : '' ) }} /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('surname'))
					<div class="validation-error">{{ $errors->first('surname') }}</div>
				@endif

				<label>Enter your surname <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="surname" value="{{ old('surname') }}" required class="input {{ $errors->has('surname') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ( $errors->has('email') )
					<div class="validation-error">{{ $errors->first('email') }}</div>
				@endif

				<label>Enter your email<span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="email" value="{{ old('email') }}" required class="input {{ $errors->has('email') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ( $errors->has('password') )
					<div class="validation-error">{{ $errors->first('password') }}</div>
				@endif

				<label>Enter your password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password" value="" required class="input {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>Confirm your password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password_confirmation" value="" class="input {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>


			<div class="form-element">
				@if ($errors->has('grading'))
					<div class="validation-error">{{ $errors->first('grading') }}</div>
				@endif

				<label>Grading <span class="validation-error">&#42;</span></label>
				<div class="form-input radio-buttons">
				@if ( is_array($gradingOptions) && count($gradingOptions) )
					<select name="grading" required class="select {{ $errors->has('grading') ? ' invalid' : '' }}">
					@foreach ( $gradingOptions as $gradingValue => $gradingLabel )
						<option value="{{ $gradingValue }}" {{ ( $gradingValue == old('grading') ? 'selected="true"' : '' ) }} class="{{ $errors->has('grading') ? ' invalid' : '' }}">{{ $gradingLabel }}</option>
					@endforeach
					</select>
				@endif
				</div>
			</div>

			<div class="form-element">
				@if ($errors->has('age'))
					<div class="validation-error">{{ $errors->first('age') }}</div>
				@endif

				<label>Age <span class="validation-error">&#42;</span></label>
				<div class="form-input">
					<select name="age" required class="select {{ $errors->has('age') ? ' invalid' : '' }}">
				@if ( is_array($ageOptions) && count($ageOptions) )
					@foreach ( $ageOptions as $ageValue => $ageLabel )
						<option value="{{ $ageValue }}" {{ ( $ageValue == old('age') ? 'selected="true"' : '' ) }}>{{ $ageLabel }}</option>
					@endforeach
				@endif
					</select>
				</div>
			</div>

			<div class="form-element">
				@if ($errors->has('gender'))
					<div class="validation-error">{{ $errors->first('gender') }}</div>
				@endif

				<label>Gender <span class="validation-error">&#42;</span></label>
				<div class="form-input radio-options">
				@foreach ( $genderOptions as $genderValue => $genderLabel )
					<div class="radio-option">
						<input type="radio" name="gender" value="{{ $genderValue }}" {{ ( $genderValue == old('gender') ? 'checked="true"' : '' ) }} class="{{ $errors->has('gender') ? ' invalid' : '' }}" class=" {{ $errors->has('gender') ? ' invalid' : '' }}" />
						<label>{{ $genderLabel }}</label>
					</div>
				@endforeach
				</div>
			</div>


			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Register" class="button submit" /></div>
			</div>
		</form>

	</div>
</div>

@endsection
