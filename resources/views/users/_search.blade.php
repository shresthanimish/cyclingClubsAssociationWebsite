<?php
/**
 * Form view to allow searching users
 */
?>
		<div class="searchContainer">
			<p>Filter Accounts By: </p>
			<form id="editForm" method="post">
				@csrf

				<div class="form-element">
					<label>Keyword</label>
					<div class="form-input"><input type="text" name="keyword" value="{{ $keyword }}" /></div>
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
					<label>Role</label>
					<div class="form-input radio-options">
						<div class="radio-option">
							<input type="radio" name="role" value="" {{ ( empty($role) ? 'checked="true"' : '' ) }} />
							<label>Any Role</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="role" value="{{ $user::ROLE_ADMIN }}" {{ ( $role == $user::ROLE_ADMIN ? 'checked="true"' : '' ) }} />
							<label>{{ $user::getRoleText($user::ROLE_ADMIN) }}</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="role" value="{{ $user::ROLE_RIDER }}" {{ ( $role == $user::ROLE_RIDER ? 'checked="true"' : '' ) }} />
							<label>{{ $user::getRoleText($user::ROLE_RIDER) }}</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="role" value="{{ $user::ROLE_CLUB }}" {{ ( $role == $user::ROLE_CLUB ? 'checked="true"' : '' ) }} />
							<label>{{ $user::getRoleText($user::ROLE_CLUB) }}</label>
						</div>
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
							<input type="radio" name="status" value="{{ $user::$STATUS_ACTIVE }}" {{ ( $status == $user::$STATUS_ACTIVE ? 'checked="true"' : '' ) }} />
							<label>{{ $user::getStatusText($user::$STATUS_ACTIVE) }}</label>
						</div>
						<div class="radio-option">
							<input type="radio" name="status" value="{{ $user::$STATUS_INACTIVE }}" {{ ( $status == $user::$STATUS_INACTIVE ? 'checked="true"' : '' ) }} />
							<label>{{ $user::getStatusText($user::$STATUS_INACTIVE) }}</label>
						</div>
					</div>
				</div>

				<div class="form-element">
					<label>&nbsp;</label>
					<div class="form-input"><input type="submit" name="search" value="Search" class="button" /></div>
				</div>
			</form>
		</div>
