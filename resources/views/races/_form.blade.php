<?php
/**
 * Form view to create/edit a Race
 */
?>
		@if ( Session::has('error') || $errors->any() )
			<p class="alert alert-error">An error occured processing your request. {{ Session::get('error') }}</p>
		@endif

		<form id="raceForm" action="{{ $route }}" method="post">
			@csrf

			<div class="form-element">
				@if ($errors->has('club_id'))
					<div class="validation-error">{{ $errors->first('club_id') }}</div>
				@endif

				<label>Club <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@if ( is_object($clubs) && count($clubs) )
					<select name="Race[club_id]" class="select" required>
					@foreach ( $clubs as $club )
						<option value="{{ $club->id }}" {{ ( $club->id == $race->club_id ? 'selected="true"' : '' ) }}>{{ $club->title }}</option>
					@endforeach
					</select>
				@endif
				</div>
			</div>

			<div class="form-element">
				@if ($errors->has('title'))
					<div class="validation-error">{{ $errors->first('title') }}</div>
				@endif

				<label>Title <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Race[title]" value="{{ $race->title }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('race_date'))
					<div class="validation-error">{{ $errors->first('race_date') }}</div>
				@endif

				<label>Race Date <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Race[race_date]" value="{{ $race->getRaceDate('d/m/Y') }}" class="input race-date" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('start_time'))
					<div class="validation-error">{{ $errors->first('start_time') }}</div>
				@endif

				<label>Start Time <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Race[start_time]" value="{{ $race->start_time }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('address'))
					<div class="validation-error">{{ $errors->first('address') }}</div>
				@endif

				<label>Address <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Race[address]" value="{{ $race->address }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('suburb'))
					<div class="validation-error">{{ $errors->first('suburb') }}</div>
				@endif

				<label>Suburb <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Race[suburb]" value="{{ $race->suburb }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('postcode'))
					<div class="validation-error">{{ $errors->first('postcode') }}</div>
				@endif

				<label>Postcode <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="Race[postcode]" value="{{ $race->postcode }}" class="input" /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('state_id'))
					<div class="validation-error">{{ $errors->first('state_id') }}</div>
				@endif

				<label>State <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@if ( is_object($states) && count($states) )
					<select name="Race[state_id]" class="select" required>
					@foreach ( $states as $state )
						<option value="{{ $state->id }}" {{ ( $state->id == $race->state_id ? 'selected="true"' : '' ) }}>{{ $state->name }}</option>
					@endforeach
					</select>
				@endif

				</div>
			</div>

			<div class="form-element">
				@if ($errors->has('status'))
					<div class="validation-error">{{ $errors->first('status') }}</div>
				@endif

				<label>Status <span class="validation-error">&#42;</span></label>
				<div class="form-input">
				@foreach ( App\Models\Race::getStatusOptions() as $statusValue => $statusLabel )
					<div class="radio-option">
						<input type="radio" name="Race[status]" value="{{ $statusValue }}" {{ ( $statusValue == $race->status ? 'checked="true"' : '' ) }} />
						<label>{{ $statusLabel }}</label>
					</div>
				@endforeach
				</div>
			</div>

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Save" class="button save" /></div>
			</div>

		</form>
