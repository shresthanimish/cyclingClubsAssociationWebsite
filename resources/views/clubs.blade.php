@extends('layouts.app')

@section('title') {{'Clubs'}} @endsection

@section('content')

<div class="find-a-club page-content-block bg-cream">
	<div class="content-block container">
		<div class="flex flex-between">
			<div>
				<h1>Clubs</h1>

				<p>This is some sample code written by Robert Alfaro.</p>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Arcu cursus vitae
					congue mauris. Condimentum id venenatis a condimentum vitae sapien pellentesque habitant. Magna eget est lorem ipsum dolor sit amet. Quisque non
					tellus orci ac auctor augue. Dictumst vestibulum rhoncus est pellentesque elit ullamcorper dignissim cras. Facilisi morbi tempus iaculis urna id
					volutpat lacus. Leo integer malesuada nunc vel risus commodo viverra maecenas. </p>
			</div>
		</div>
	</div>
</div>


<div class="upcoming-races page-content-block bg-pale-blue">
	<div class="content-block container">
		<div class="flex flex-between">
			<div class="container">
				<h3>Find a club near you</h3>

				<div>
					<form id="searchForm" method="post" class="search-form">
						@csrf

						<div class="form-element">
							<label>Keyword</label>
							<div class="form-input"><input type="text" name="keyword" value="{{ $keyword }}" class="input" /></div>
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
							<label>&nbsp;</label>
							<div class="form-input"><input type="submit" name="search" value="Search" class="button" /></div>
						</div>
					</form>

				</div>

	@if ( !empty($clubs) )
		@include('clubs._list', [
			'clubs' => $clubs,
			'isAdmin' => false,
		])
	@endif

			</div>
		</div>

	</div>
</div>


@endsection
