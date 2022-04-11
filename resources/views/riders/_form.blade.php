<?php
/**
 * Form view to create/edit a Rider
 */
?>
		<form id="riderForm" action="{{ $route }}" method="post">
			@csrf

			<div class="form-element">
				@if ($errors->has('club_id'))
					<div class="validation-error">{{ $errors->first('club_id') }}</div>
				@endif

				<label>Club <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@if ( is_object($clubs) && count($clubs) )
					<select name="User[club_id]" required autofocus class="select {{ $errors->has('club_id') ? ' invalid' : '' }}">
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

				<label>First name <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="User[first_name]" value="{{ old('first_name', $user->first_name) }}" required class="input {{ $errors->has('first_name') ? ' invalid' : '' }}" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('surname'))
					<div class="validation-error">{{ $errors->first('surname') }}</div>
				@endif

				<label>Surname <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="User[surname]" value="{{ old('surname', $user->surname) }}" required class="input {{ $errors->has('surname') ? ' invalid' : '' }}" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('email'))
					<div class="validation-error">{{ $errors->first('email') }}</div>
				@endif

				<label>Email <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="User[email]" value="{{  old('email', $user->email) }}" required class="input {{ $errors->has('email') ? ' invalid' : '' }}" required /></div>
			</div>

		@if ( $create )

			<div class="form-element">
				@if ($errors->has('password'))
					<div class="validation-error">{{ $errors->first('password') }}</div>
				@endif

				<label>Password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="User[password]" value="" required class="input {{ $errors->has('password') ? ' invalid' : '' }}" /></div>
			</div>

			<div class="form-element">
				<label>Confirm Password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="User[password_confirmation]" value="" required class="input {{ $errors->has('password_confirmation') ? ' invalid' : '' }}" /></div>
			</div>

		@endif

			<div class="form-element">
				@if ($errors->has('grading'))
					<div class="validation-error">{{ $errors->first('grading') }}</div>
				@endif

				<label>Grading <span class="validation-error">&#42;</span></label>
				<div class="form-input radio-buttons">
				@php($gradingOptions = $rider::getGradingOptions())
				@if ( is_array($gradingOptions) && count($gradingOptions) )
					<select name="Rider[grading]" required class="select {{ $errors->has('grading') ? ' invalid' : '' }}">
					@foreach ( $gradingOptions as $gradingValue => $gradingLabel )
						<option value="{{ $gradingValue }}" {{ ( $gradingValue == old('grading', $rider->grading) ? 'selected="true"' : '' ) }} class="{{ $errors->has('grading') ? ' invalid' : '' }}">{{ $gradingLabel }}</option>
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
					<select name="Rider[age]" required class="select {{ $errors->has('age') ? ' invalid' : '' }}">
				@php($ageOptions = $rider::getAgeOptions())
				@if ( is_array($ageOptions) && count($ageOptions) )
					@foreach ( $ageOptions as $ageValue => $ageLabel )
						<option value="{{ $ageValue }}" {{ ( $ageValue == old('age', $rider->age) ? 'selected="true"' : '' ) }}>{{ $ageLabel }}</option>
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
				@foreach ( $rider::getGenderOptions() as $genderValue => $genderLabel )
					<div class="radio-option">
						<input type="radio" name="Rider[gender]" value="{{ $genderValue }}" {{ ( $genderValue == old('role', $rider->gender) ? 'checked="true"' : '' ) }} class="{{ $errors->has('gender') ? ' invalid' : '' }}" class=" {{ $errors->has('gender') ? ' invalid' : '' }}" />
						<label>{{ $genderLabel }}</label>
					</div>
				@endforeach
				</div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Save" class="button submit save" /></div>
			</div>

		</form>
