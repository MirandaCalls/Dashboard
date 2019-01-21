<html>
	<head>
		<title>Dashboard - <?php echo $page_title ?></title>
		<link rel="shortcut icon" href="img/icon.png" />
		<link type="text/css" rel="stylesheet" href="css/materialize.css" media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/shared.css"/>
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.js"></script>
		<script type="text/javascript">
			document.addEventListener( 'DOMContentLoaded', function() {
				var elems = document.querySelectorAll( '.sidenav' );
				var options = {};
				var instances = M.Sidenav.init( elems, options );
			});
		</script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="mobile-web-app-capable" content="yes">
	</head>
	<body>
		<header>
			<div class="navbar-fixed">
				<nav class="blue-grey darken-1">
					<div class="nav-wrapper container">
						<a href="/" class="brand-logo">Dashboard</a>
						<a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
						<ul class="right hide-on-med-and-down">
							<?php $uri = $request->uri() ?>
							<li class="<?php echo ( '/' == $uri ? 'active' : '' ) ?>"><a href="/">Home</a></li>
							<li class="<?php echo ( '/inventory' == $uri ? 'active' : '' ) ?>"><a href="/inventory">Inventory</a></li>
							<li class="<?php echo ( '/weather' == $uri ? 'active' : '' ) ?>"><a href="/weather">Weather</a></li>
							<li class="<?php echo ( '/speedlogs' == $uri ? 'active' : '' ) ?>"><a href="/speedlogs">Speed Tests</a></li>
							<li class="<?php echo ( '/configuration' == $uri ? 'active' : '' ) ?>"><a href="/configuration"><i class="material-icons">settings</i></a></li>
						</ul>
					</div>
				</nav>
			</div>
			<ul class="sidenav blue-grey darken-2" id="mobile-nav">
				<li><a class="white-text" href="/"><i class="material-icons">home</i>Home</a></li>
				<li><a class="white-text" href="/inventory"><i class="material-icons">storage</i>Inventory</a></li>
				<li><a class="white-text" href="/weather"><i class="material-icons">cloud</i>Weather</a></li>
				<li><a class="white-text" href="/speedlogs"><i class="material-icons">signal_wifi_4_bar</i>Speed Tests</a></li>
				<li><a class="white-text" href="/configuration"><i class="material-icons">settings</i>Settings</a></li>
			</ul>
		</header>
		<main>
			<div class="container">
