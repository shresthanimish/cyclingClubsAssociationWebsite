@extends('layouts.app')

@section('title') {{'Welcome'}} @endsection

@section('content')

<div class="welcome home-content-block bg-dark-blue">
	<div class="content-block container">
		<div class="flex flex-between">
			<div class="flex flex-align-centered align-center column column-5 bg-black">
				<h2>PHOTO GOES HERE</h2>
			</div>
			<div class="content-block column column-7">
				<h1>Welcome</h1>

				<p>This is some sample code written by Robert Alfaro.</p>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet arcu et ante tincidunt cursus ac nec ligula. Duis
					commodo tincidunt diam nec scelerisque. Mauris dignissim erat non ullamcorper lacinia. Integer pulvinar nulla fermentum nibh
					euismod pellentesque sit amet nec sem.</p>

				<p>Nulla in varius dui, eget dictum nulla. Sed et nisl dignissim, finibus justo quis, ornare elit. Nam non justo molestie odio dapibus porttitor.
				Integer euismod id tortor at vehicula.</p>

				<p>Praesent at arcu egestas, rutrum mauris et, luctus magna. Sed nisl risus, varius sed diam quis, tempus placerat nulla. Cras id consequat
				augue, eu egestas tortor. Suspendisse semper orci sed odio malesuada dictum. Nam dignissim leo ac sodales egestas.</p>

				<div class="button"><a href="{{ route('about-us') }}">About Us</a></div>

			</div>
		</div>

	</div>
</div>

<div class="find-a-club home-content-block bg-cream">
	<div class="content-block container">
		<div class="flex flex-between">
			<div class="content-block column column-7">
				<h3>Find a club near you</h3>

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet arcu et ante tincidunt cursus ac nec ligula. Duis
					commodo tincidunt diam nec scelerisque. Mauris dignissim erat non ullamcorper lacinia. Integer pulvinar nulla fermentum nibh
					euismod pellentesque sit amet nec sem.</p>

				<p>Nulla in varius dui, eget dictum nulla. Sed et nisl dignissim, finibus justo quis, ornare elit. Nam non justo molestie odio dapibus porttitor.
				Integer euismod id tortor at vehicula.</p>

				<p>Praesent at arcu egestas, rutrum mauris et, luctus magna. Sed nisl risus, varius sed diam quis, tempus placerat nulla. Cras id consequat
				augue, eu egestas tortor. Suspendisse semper orci sed odio malesuada dictum. Nam dignissim leo ac sodales egestas.</p>

				<div class="button"><a href="{{ route('register') }}">Register to a club</a></div>

			</div>
			<div class="flex flex-align-centered align-center column column-5 bg-black">
				<h2>PHOTO GOES HERE</h2>
			</div>
		</div>
	</div>
</div>

<div class="register-your-club home-content-block bg-pale-blue">
	<div class="content-block container">
		<div class="flex flex-between">
			<div class="flex flex-align-centered align-center column column-5 bg-black">
				<h2>PHOTO GOES HERE</h2>
			</div>
			<div class="content-block column column-7">
				<h3>Register your club</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet arcu et ante tincidunt cursus ac nec ligula. Duis
					commodo tincidunt diam nec scelerisque. Mauris dignissim erat non ullamcorper lacinia. Integer pulvinar nulla fermentum nibh
					euismod pellentesque sit amet nec sem.</p>

				<p>Nulla in varius dui, eget dictum nulla. Sed et nisl dignissim, finibus justo quis, ornare elit. Nam non justo molestie odio dapibus porttitor.
				Integer euismod id tortor at vehicula.</p>

				<p>Praesent at arcu egestas, rutrum mauris et, luctus magna. Sed nisl risus, varius sed diam quis, tempus placerat nulla. Cras id consequat
				augue, eu egestas tortor. Suspendisse semper orci sed odio malesuada dictum. Nam dignissim leo ac sodales egestas.</p>

				<div class="button"><a href="{{ route('clubs') }}">Register to a club</a></div>

			</div>
		</div>
	</div>
</div>

<div class="join-a-club home-content-block bg-orange">
	<div class="content-block container">
		<div class="flex flex-between">
			<div class="content-block column column-7">
				<h3>Join a club</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet arcu et ante tincidunt cursus ac nec ligula. Duis
					commodo tincidunt diam nec scelerisque. Mauris dignissim erat non ullamcorper lacinia. Integer pulvinar nulla fermentum nibh
					euismod pellentesque sit amet nec sem.</p>

				<p>Nulla in varius dui, eget dictum nulla. Sed et nisl dignissim, finibus justo quis, ornare elit. Nam non justo molestie odio dapibus porttitor.
				Integer euismod id tortor at vehicula.</p>

				<p>Praesent at arcu egestas, rutrum mauris et, luctus magna. Sed nisl risus, varius sed diam quis, tempus placerat nulla. Cras id consequat
				augue, eu egestas tortor. Suspendisse semper orci sed odio malesuada dictum. Nam dignissim leo ac sodales egestas.</p>

				<div class="button"><a href="{{ route('register') }}">Register to a club</a></div>

			</div>
			<div class="flex flex-align-centered align-center column column-5 bg-black">
				<h2>PHOTO GOES HERE</h2>
			</div>
		</div>
	</div>
</div>


@endsection
