<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Club, Race and Rider Example</title>

	<link rel='dns-prefetch' href='//fonts.googleapis.com' />
	<link rel="stylesheet" type="text/css" href="/css/global.css" media="screen" />
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
<div id="page" class="site">
	<header>
		<nav>
			<ul>
				<li><a href="{{ route('/clubs/index') }}">Manage Clubs</a></li>
				<li><a href="{{ route('/races/index') }}">Manage Races</a></li>
				<li><a href="{{ route('/riders/index') }}">Manage Riders</a></li>
			</ul>
		</nav>
	</header>

	<main id="main" class="site-main">

<!-- Start content -->


@yield('content')


<!-- End content -->

	</main>
</div>
</body>
</html>
