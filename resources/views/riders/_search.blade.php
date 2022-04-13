<?php
/**
 * Search view to search/filter Riders
 */
?>
		<div class="search-container">
			<p>Filter Riders By: </p>
			<form id="searchForm" method="post">
				@csrf

				<div class="form-element">
					<label>Keyword</label>
					<div class="form-input"><input type="text" name="keyword" value="{{ $keyword }}" autofocus class="input" /></div>
				</div>

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
					<label>Gender</label>
					<div class="form-input radio-options">
						<div class="radio-option">
							<input type="radio" name="gender" value="" {{ ( empty($gender) ? 'checked="true"' : '' ) }} />
							<label>Any Gender</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="gender" value="{{ $rider::GENDER_FEMALE }}" {{ ( $gender == $rider::GENDER_FEMALE ? 'checked="true"' : '' ) }} />
							<label>{{ $rider::getGenderText($rider::GENDER_FEMALE) }}</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="gender" value="{{ $rider::GENDER_MALE }}" {{ ( $gender == $rider::GENDER_MALE ? 'checked="true"' : '' ) }} />
							<label>{{ $rider::getGenderText($rider::GENDER_MALE) }}</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="gender" value="{{ $rider::GENDER_OTHER }}" {{ ( $gender == $rider::GENDER_OTHER ? 'checked="true"' : '' ) }} />
							<label>{{ $rider::getGenderText($rider::GENDER_OTHER) }}</label>
						</div>
					</div>
				</div>

				<div class="form-element">
					<label>&nbsp;</label>
					<div class="form-input"><input type="submit" name="search" value="Search" class="button" /></div>
				</div>
			</form>
		</div>
