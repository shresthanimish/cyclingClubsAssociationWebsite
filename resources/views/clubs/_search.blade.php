<?php
/**
 * Search view to search/filter Clubs
 */
?>
		<div class="search-container">
			<p>Filter Clubs By: </p>
			<form id="searchForm" method="post">
				@csrf

				<div class="form-element">
					<label>Keyword</label>
					<div class="form-input"><input type="text" name="keyword" value="{{ $keyword }}" autofocus class="input" /></div>
				</div>

				<div class="form-element">
					<label>State <span class="validation-error">&#42;</span></label>
					<div class="form-input">
					@if ( is_object($states) && count($states) )
						<select name="statesId" required class="select">
							<option value="">All states</option>
						@foreach ( $states as $state )
							<option value="{{ $state->id }}" {{ ( $state->id ==  old('state_id') ? 'selected="true"' : '' ) }}>{{ $state->name }}</option>
						@endforeach
						</select>
					@endif
					</div>
				</div>

				<div class="form-element">
					<label>&nbsp;</label>
					<div class="form-input"><input type="submit" name="search" value="Search" class="button" /></div>
				</div>
			</form>
		</div>
