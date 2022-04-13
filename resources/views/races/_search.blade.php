<?php
/**
 * Search view to search/filter Races
 */
?>
		<div class="search-container">
			<p>Filter Races By: </p>
			<form id="searchForm" method="post">
				@csrf

				<div class="form-element">
					<label>Keyword</label>
					<div class="form-input"><input type="text" name="keyword" value="{{ $keyword }}" autofocus class="input" /></div>
				</div>
		<?php
		/*
		TODO: Add filter by select menu for
				'date',
		*/
		?>

				<div class="form-element">
					<label>Club </label>
					<div class="form-input">
					@if ( is_object($clubs) && count($clubs) )
						<select name="clubsId" class="select">
							<option value="">All clubs</option>
						@foreach ( $clubs as $club )
							<option value="{{ $club->id }}" {{ ( $club->id == $clubsId ? 'selected="true"' : '' ) }}>{{ $club->title }}</option>
						@endforeach
						</select>
					@endif
					</div>
				</div>

				<div class="form-element">
					<label>State <span class="validation-error">&#42;</span></label>
					<div class="form-input">
					@if ( is_object($states) && count($states) )
						<select name="statesId" class="select">
							<option value="">All states</option>
						@foreach ( $states as $state )
							<option value="{{ $state->id }}" {{ ( $state->id ==  old('state_id') ? 'selected="true"' : '' ) }}>{{ $state->name }}</option>
						@endforeach
						</select>
					@endif
					</div>
				</div>

				<div class="form-element">
					<label>Status</label>
					<div class="form-input radio-options">
						<div class="radio-option">
							<input type="radio" name="status" value="" {{ ( empty($status) ? 'checked="true"' : '' ) }} />
							<label>Any Status</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="status" value="{{ $race::STATUS_PENDING }}" {{ ( $status == $race::STATUS_PENDING ? 'checked="true"' : '' ) }} />
							<label>{{ $race::getStatusText($race::STATUS_PENDING) }}</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="status" value="{{ $race::STATUS_COMPLETE }}" {{ ( $status == $race::STATUS_COMPLETE ? 'checked="true"' : '' ) }} />
							<label>{{ $race::getStatusText($race::STATUS_COMPLETE) }}</label>
						</div>
					</div>
				</div>

				<div class="formElement">
					<label>&nbsp;</label>
					<div class="form-input"><input type="submit" name="search" value="Search" class="button" /></div>
				</div>
			</form>
		</div>
