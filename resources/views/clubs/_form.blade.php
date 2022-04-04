<?php
/**
 * Form view to create/edit a Club
 */
?>
		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured processing your request. {{ Session::get('error') }}</p>
		@endif

		<form id="clubForm" action="{{ $route }}" method="post">
			@csrf

			<div class="form-element">
				@if ($errors->has('title'))
					<div class="validation-error">{{ $errors->first('title') }}</div>
				@endif

				<label>Title <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Club[title]" value="{{ $club->title }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('address'))
					<div class="validation-error">{{ $errors->first('address') }}</div>
				@endif

				<label>Address <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Club[address]" value="{{ $club->address }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('suburb'))
					<div class="validation-error">{{ $errors->first('suburb') }}</div>
				@endif

				<label>Suburb <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Club[suburb]" value="{{ $club->suburb }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('postcode'))
					<div class="validation-error">{{ $errors->first('postcode') }}</div>
				@endif

				<label>Postcode <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Club[postcode]" value="{{ $club->postcode }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('state_id'))
					<div class="validation-error">{{ $errors->first('state_id') }}</div>
				@endif

				<label>State <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@if ( is_object($states) && count($states) )
					<select name="Club[state_id]" class="select" required>
					@foreach ( $states as $state )
						<option value="{{ $state->id }}" {{ ( $state->id == $club->state_id ? 'selected="true"' : '' ) }}>{{ $state->name }}</option>
					@endforeach
					</select>
				@endif
				</div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Save" class="button save" /></div>
			</div>

		</form>
