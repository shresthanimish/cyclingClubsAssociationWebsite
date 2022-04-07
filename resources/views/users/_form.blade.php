@extends('layouts.app')

@section('content')

		<form method="post" action="{{ $route }}">
			@csrf

			<div class="form-element">
				@if ($errors->has('first_name'))
					<div class="validation-error">{{ $errors->first('first_name') }}</div>
				@endif

				<label>First name <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="first_name" value="{{ $user->first_name }}" class="field {{ $errors->has('first_name') ? ' invalid' : '' }}" required autofocus /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('surname'))
					<div class="validation-error">{{ $errors->first('surname') }}</div>
				@endif

				<label>Surname <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="text" name="surname" value="{{ $user->surname }}" class="field {{ $errors->has('surname') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				@if ($errors->has('email'))
					<div class="validation-error">{{ $errors->first('email') }}</div>
				@endif

				<label>Email <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="email" name="email" value="{{ $user->email }}" class="field {{ $errors->has('email') ? ' invalid' : '' }}" required /></div>
			</div>

		@if ( !$limited )
			<div class="form-element">
				@if ($errors->has('role'))
					<div class="validation-error">{{ $errors->first('role') }}</div>
				@endif

				<label>Role <span class="validation-error">&#42;</span></label>
				<div class="form-input radio-options">
					<div class="radio-option">
						<input type="radio" name="role" value="{{ $user::ROLE_ADMIN }}" {{ ($user->role == $user::ROLE_ADMIN ? 'checked="true"' : '' ) }} required />
						<label>{{ $user::getRoleText($user::ROLE_ADMIN) }}</label>
					</div>
					<div class="radio-option">
						<input type="radio" name="role" value="{{ $user::ROLE_RIDER }}" {{ ($user->role == $user::ROLE_RIDER ? 'checked="true"' : '' ) }} required />
						<label>{{ $user::getRoleText($user::ROLE_RIDER) }}</label>
					</div>
					<div class="radio-option">
						<input type="radio" name="role" value="{{ $user::ROLE_RIDER }}" {{ ($user->role == $user::ROLE_CLUB ? 'checked="true"' : '' ) }} required />
						<label>{{ $user::getRoleText($user::ROLE_CLUB) }}</label>
					</div>
				</div>
			</div>
		@endif

		@if ( $create )

			<div class="form-element">
				@if ($errors->has('password'))
					<div class="validation-error">{{ $errors->first('password') }}</div>
				@endif

				<label>Password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password" value="" class="field {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

			<div class="form-element">
				<label>Confirm Password <span class="validation-error">&#42;</span></label>
				<div class="form-input"><input type="password" name="password_confirmation" value="" class="field {{ $errors->has('password') ? ' invalid' : '' }}" required /></div>
			</div>

		@else

			<div class="form-element notes">
				<label>Status</label>
				<div class="form-input">{{ $user->status }}</div>
			</div>

			@if ( !empty($user->email_verified_at) )
			<div class="form-element notes">
				<label>Email Verified</label>
				<div class="form-input">{{ $user->email_verified_at }}</div>
			</div>
			@endif

			@if ( !empty($user->created_at) )
			<div class="form-element notes">
				<label>Account Created</label>
				<div class="form-input">{{ $user->created_at }}</div>
			</div>
			@endif

			@if ( !empty($user->updated_at) )
			<div class="form-element notes">
				<label>Account Updated</label>
				<div class="form-input">{{ $user->updated_at }}</div>
			</div>
			@endif

			@if ( !empty($user->approved_at) )
			<div class="form-element notes">
				<label>Account Approved</label>
				<div class="form-input">{{ $user->approved_at }}</div>
			</div>
			@endif

		@endif

			<div class="form-element">
				<label>&nbsp;</label>
				<div class="form-input"><input type="submit" name="process" value="Save" class="button submit save" /></div>
			</div>

		</form>

@endsection
