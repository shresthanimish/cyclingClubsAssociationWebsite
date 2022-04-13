<?php
/**
 * Paginated list view items
 * @note Default action for ClubController
 */
?>

		<div id="clubsList" class="clubs-list list-container">

	@if ( isset($clubs) && count($clubs) )

			<div class="club-items list-items">
				<div class="club-item row list-header list-item">
					<div class="title column {{ ( $isAdmin ? 'column-3' : 'column-2' ) }}">Title</div>
					<div class="address column column-3">Address</div>
					<div class="suburb column column-3">Suburb</div>
					<div class="postcode column column-1">Postcode</div>
					<div class="state column column-2">State</div>
		@if ( $isAdmin )
					<div class="actions column column-1 align-right">&nbsp;</div>
		@endif
				</div>

		@foreach ( $clubs as $club )

				<div class="club-item row list-item">
					<div class="first-name column {{ ( $isAdmin ? 'column-3' : 'column-2' ) }}">{{ $club->title }}</div>
					<div class="address column column-3">{{ $club->address }}</div>
					<div class="suburb column column-3">{{ $club->suburb }}</div>
					<div class="postcode column column-1">{{ $club->postcode }}</div>
					<div class="state column column-2">{{ ( isset($club->state) ? $club->state->name : 'n/a' ) }}</div>
		@if ( $isAdmin )
					<div class="actions column column-1 align-right"><a href="{{ route('/clubs/details', $club->id) }}">View</a></div>
		@endif
				</div>

		@endforeach

			</div>

		{{ $clubs->links('vendor.pagination.custom') }}
	@endif

		</div>
