@extends('layouts.app')

@section('title') {{'Contact Us'}} @endsection

@section('content')

<div class="find-a-club page-content-block full-height bg-cream">
	<div class="content-block container bg-white">
		<div class="flex flex-between container-padded">
			<div class="column">
				<h1>Contact Us</h1>

				<p>This is some sample code written by Robert Alfaro.</p>

				@if ( Session::has('success') )
					<p class="alert alert-success">{{ Session::get('success') }}</p>
				@endif

				@if ( Session::has('error') || $errors->any() )
					<p class="alert alert-error">{{ Session::get('error') }}</p>
				@endif

				<form id="riderForm" action="{{ route('contact.store') }}" method="post">
					@csrf

					<div class="form-element">
						@if ($errors->has('name'))
							<div class="validation-error">{{ $errors->first('name') }}</div>
						@endif

						<label>Your name <span class="validation-error">&#42;</span></label>
						<div class="form-input"><input type="text" name="name" value="{{ old('name') }}" required class="input {{ $errors->has('name') ? ' invalid' : '' }}" /></div>
					</div>

					<div class="form-element">
						@if ($errors->has('email'))
							<div class="validation-error">{{ $errors->first('email') }}</div>
						@endif

						<label>Your Email <span class="validation-error">&#42;</span></label>
						<div class="form-input"><input type="email" name="email" value="{{  old('email') }}" required class="input {{ $errors->has('email') ? ' invalid' : '' }}" required /></div>
					</div>

					<div class="form-element">
						@if ($errors->has('phone'))
							<div class="validation-error">{{ $errors->first('phone') }}</div>
						@endif

						<label>Your Phone Number <span class="validation-error">&#42;</span></label>
						<div class="form-input"><input type="phone" name="phone" value="{{ old('phone') }}" required class="input {{ $errors->has('phone') ? ' invalid' : '' }}" /></div>
					</div>

					<div class="form-element">
						@if ($errors->has('subject'))
							<div class="validation-error">{{ $errors->first('subject') }}</div>
						@endif

						<label>Subject <span class="validation-error">&#42;</span></label>
						<div class="form-input"><input type="text" name="subject" value="{{ old('subject') }}" required class="input {{ $errors->has('subject') ? ' invalid' : '' }}" /></div>
					</div>

					<div class="form-element">
						@if ($errors->has('message'))
							<div class="validation-error">{{ $errors->first('message') }}</div>
						@endif

						<label>Your Message <span class="validation-error">&#42;</span></label>
						<div class="form-input"><textarea name="message" required class="textarea {{ $errors->has('message') ? ' invalid' : '' }}">{{ old('message') }}</textarea></div>
					</div>

					<div class="form-element">
						<label>&nbsp;</label>
						<div class="form-input"><input type="submit" name="process" value="Send" class="button submit save" /></div>
					</div>

				</form>



			</div>
		</div>
	</div>
</div>

@endsection
