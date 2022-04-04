<?php
/**
 * Form view to create/edit a Rider
 */
?>
		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured processing your request. {{ Session::get('error') }}</p>
		@endif

		<form id="riderForm" action="{{ $route }}" method="post">
			@csrf

			<div class="form-element">
				@if ($errors->has('club_id'))
					<div class="validation-error">{{ $errors->first('club_id') }}</div>
				@endif

				<label>Club <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@if ( is_object($clubs) && count($clubs) )
					<select name="Rider[club_id]" class="select" required>
					@foreach ( $clubs as $club )
						<option value="{{ $club->id }}" {{ ( $club->id == $rider->club_id ? 'selected="true"' : '' ) }}>{{ $club->title }}</option>
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
				<div class="form-input"><input type="text" name="Rider[first_name]" value="{{ $rider->first_name }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('surname'))
					<div class="validation-error">{{ $errors->first('surname') }}</div>
				@endif

				<label>Surname <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Rider[surname]" value="{{ $rider->surname }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('grading'))
					<div class="validation-error">{{ $errors->first('grading') }}</div>
				@endif

				<label>Grading <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@php($gradingOptions = $rider::getGradingOptions())
				@if ( is_array($gradingOptions) && count($gradingOptions) )
					<select name="Rider[grading]" class="select">
					@foreach ( $gradingOptions as $gradingValue => $gradingLabel )
						<option value="{{ $gradingValue }}" {{ ( $rider->grading == $gradingValue ? 'selected="true"' : '' ) }}>{{ $gradingLabel }}</option>
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
					<select name="Rider[age]" class="select">
				@php($ageOptions = $rider::getAgeOptions())
				@if ( is_array($ageOptions) && count($ageOptions) )
					@foreach ( $ageOptions as $ageValue => $ageLabel )
						<option value="{{ $ageValue }}" {{ ( $rider->age == $ageValue ? 'selected="true"' : '' ) }}>{{ $ageLabel }}</option>
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
						<input type="radio" name="Rider[gender]" value="{{ $genderValue }}" {{ ( $genderValue == $rider->gender ? 'checked="true"' : '' ) }} />
						<label>{{ $genderLabel }}</label>
					</div>
				@endforeach
				</div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Save" class="button save" /></div>
			</div>

		</form>
