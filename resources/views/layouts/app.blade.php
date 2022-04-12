<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>

	<link rel='dns-prefetch' href='//fonts.googleapis.com' />
	<link rel="stylesheet" type="text/css" href="/css/app.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css" media="screen" />

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
	<script>
		$( function() {
			$('input.race-date').datepicker({
				inline: true,
				autoSize: false,
				showOtherMonths: true,
				dateFormat: 'dd/mm/yy',
			});
		});
	</script>
</head>

<body>
<div id="page" class="site {{ Auth::check() ? 'admin' : 'default' }}">
	<header class="{{ Auth::check() ? 'admin' : 'default' }}">
		<nav class="primary-navigation">
			<div class="content-block container row flex-between">
				<div class="logo"><a href="/">Logo goes here</a></div>
				<ul class="no-bullet row flex-between">
					<li><a href="/">Home</a></li>
					<li><a href="{{ route('about-us') }}">About Us</a></li>
					<li><a href="{{ route('clubs') }}">Clubs</a></li>
					<li><a href="{{ route('races') }}">Races</a></li>
					<li><a href="{{ route('contact-us') }}">Contact Us</a></li>
				</ul>
				<div class="flex flex-column flex-center login align-center">
@if ( !Auth::check() )
					<div class="button"><a href="{{ route('login') }}">Login</a></div>
					<p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
@endif
				</div>
			</div>
		</nav>

@if ( Auth::check() )
@php( $loggedInUser = Auth::user() )

		<nav class="admin-navigation">
			<div class="content-block container row flex-between">
				<ul class="no-bullet row flex-between">

	@if ( $loggedInUser->role == \App\Models\User::ROLE_ADMIN )
					<li><a href="{{ route('/clubs/index') }}">Clubs</a></li>
					<li><a href="{{ route('/races/index') }}">Races</a></li>
					<li><a href="{{ route('/riders/index') }}">Riders</a></li>
					<li><a href="{{ route('/users/index') }}">Accounts</a></li>
	@endif

					<li><a href="{{ route('/profile/details') }}">Edit my details</a></li>
					<li><a href="{{ route('/profile/password') }}">Change my password</a></li>
					<li><a href="{{ route('logout') }}">Logout</a></li>
				</ul>
			</div>
		</nav>

@endif

	</header>

	<main id="main" class="site-main">

<!-- Start content -->


@yield('content')


<!-- End content -->

	</main>

	<footer>
		<nav class="footer-navigation">
			<div class="content-block container row flex-between">
				<div class="social-media">
					<p>Some social media links go here</p>
				</div>
				<div class="footer-links">
					<p>Some links go here</p>
				</div>
				<div class="copyright">
					<p>Copyright @copyright 2022</p>
				</div>
			</div>
		</nav>
	</footer>
</div>
</body>
</html>
