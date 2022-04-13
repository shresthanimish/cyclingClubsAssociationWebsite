@extends('layouts.app')

@section('title') {{'Races'}} @endsection

@section('content')

<div class="find-a-club page-content-block bg-cream">
	<div class="content-block container container-padded">
		<div class="flex flex-between">
			<div>
				<h1>Races</h1>

				<p>This is some sample code written by Robert Alfaro.</p>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Arcu cursus vitae
					congue mauris. Condimentum id venenatis a condimentum vitae sapien pellentesque habitant. Magna eget est lorem ipsum dolor sit amet. Quisque non
					tellus orci ac auctor augue. Dictumst vestibulum rhoncus est pellentesque elit ullamcorper dignissim cras. Facilisi morbi tempus iaculis urna id
					volutpat lacus. Leo integer malesuada nunc vel risus commodo viverra maecenas. Pellentesque nec nam aliquam sem et. Id interdum velit laoreet id
					donec ultrices tincidunt arcu non. In ornare quam viverra orci sagittis eu volutpat odio facilisis.</p>
			</div>
		</div>
	</div>
</div>

<div class="upcoming-races page-content-block bg-dark-blue">
	<div class="content-block container container-padded">
		<div class="flex">
			<div class="container">
				<h2>Upcoming Races</h2>

				<div class="upcoming-races-list races-list">

	@if ( isset($upcomingRaces) && count($upcomingRaces) )
		@foreach ( $upcomingRaces as $race )

					<div class="race-item">
						<h5>{{ $race->title }}</h5>

						<div class="details">
							{!! ( isset($race->club) ? '<p>Club: <strong>' . $race->club->title . '</strong></p>' : '' ) !!}
							<p>Race Date: {{ $race->getRaceDate('l jS F') }} {{ $race->start_time }}</p>
							<p>Number of entrants: <strong>{{ \App\Models\Entrant::getNumberEntrants($race->id) }}</strong></p>
						</div>
					</div>

		@endforeach
	@else

					<p>There are no upcoming races.</p>

	@endif
				</div>

			</div>
		</div>

	</div>
</div>

<div class="race-results page-content-block bg-orange">
	<div class="content-block container container-padded">
		<div class="flex">
			<div class="container">
				<h3>Race Results</h3>

				<div class="upcoming-races-list races-list">

	@if ( isset($recentRaces) && count($recentRaces) )
		@foreach ( $recentRaces as $race )
			@php ( $numberOfEntrants = \App\Models\Entrant::getNumberEntrants($race->id) )

					<div class="race-item">
						<h5>{{ $race->title }}</h5>

						<div class="details">
							{!! ( isset($race->club) ? '<p><strong>' . $race->club->title . '</strong><p>' : '' ) !!}
							<p>{{ $race->getRaceDate('l jS F') }} {{ $race->start_time }}</p>
							<p>Number of entrants: <strong>{{ $numberOfEntrants }}</strong></p>
						</div>

						<div class="placings">

			@if ( $numberOfEntrants > 0 )
				@php ( $placings = \App\Models\Entrant::getPlacings($race->id, 10) )
				@foreach ( $placings as $entrant )
						<div>
							{{ $entrant->place }}: {{ ( isset($entrant->rider) && isset($entrant->rider->user) ? $entrant->rider->user->getFullName() : 'n/a' ) }}
						</div>
				@endforeach
			@endif

						</div>
					</div>

		@endforeach
	@else

		<p>There are no recently completed races.</p>

	@endif

				</div>
			</div>
		</div>

	</div>
</div>

@endsection
