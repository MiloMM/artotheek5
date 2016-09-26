<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	{{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="De DaVinci Galleria">
	<meta name="author" content="DaVinci College">

	<title>DaVinci Galleria</title>

	{{-- <link href="{{ asset('/css/main.css') }}" rel="stylesheet"> --}}
	{{-- <link href="{{ asset('/css/style.css') }}" rel="stylesheet"> --}}
	<link rel="stylesheet" href="{{ asset('/css/darkroom.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	{{-- <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'> --}}
	{{-- Tags --}}
	<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css">

	<link rel="stylesheet" href="{{ asset('css/jasny-bs.css') }}"/>
	<link rel="stylesheet" href="{{ asset('css/navmenu-reveal.css') }}">
	<link rel='stylesheet' href="{{ asset('/css/fullcalendar.css') }}"/>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

</head>
<body ng-app="application">

<div id="custom_navmenu" class="custom_navmenu">
	<span id="custom_navbar_toggle_two" class="glyphicon glyphicon-remove custom_glyphicon-remove"></span>
	<a class="navmenu-brand" href="/">DaVinci Galleria</a>
	<ul class="nav navmenu-nav">
		<li><a href="/about">Over DaVinci Galleria</a></li>
		<li><a href="/gallery">Gallerij</a></li>
		<li><a href="#">Uitleenvoorwaarden</a></li>
		<li><a href="#">Nieuws</a></li>
		<li><a href="/artists">Kustenaars</a></li>
		<li><a href="/reservations">Reserveringen</a></li>
		<li><a href="" id="searchbutton_menu">Kunstwerk zoeken<span class="glyphicon glyphicon-search" style="margin-left:10px;"></span></a></li>
		@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
			<li><a href="/filters">Filters Aanpassen</a></li>
		@endif
	</ul>
	<ul class="nav navmenu-nav">
		@if (Auth::guest())
			<li><a href="/auth/login">Login</a></li>
			<li><a href="/auth/register">Registreer</a></li>
		@else
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <b class="caret"></b></a>
				<ul class="dropdown-menu navmenu-nav">
					<li><a href="/myprofile">My Profile</a></li>
					<li><a href="{{ URL::to('logout') }}">Logout</a></li>
				</ul>
			</li>
		@endif
	</ul>
</div>

@include('header/search')

<div class="canvas">
	<div class="navbar navbar-default navbar-fixed-top" style="position: relative;">
		<div class="custom-navbar-left" style="float: left;">
			<a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo Image" style="width: 150px; margin: 8px 0 0 10px;"></a>
		</div>
			
		<div class="custom-navbar-right" style="float: right;">
			<button id="searchtoggle" class="btn btn-default" style="float: left; margin-top: 9px; padding: 5px 15px 5px 15px;">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		    <button type="button" id="custom_navbar_toggle" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
		</div>
	</div>

	<div class="container content">
		<div class="row">
			@yield('content')
		</div>
	</div>
	<div class="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<h4>Contactgegevens</h4>
				Da Vinci Artotheek<br>
				Straat 123<br>
				1234 AB Stad<br>
				artotheek@davinci.nl<br>
			</div>
		</div>
	</div>
</div>
</div>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Scripts -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>--}}
<script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.5.0/fabric.min.js"></script>
<script src="{{ asset('js/darkroom.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('functions.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular-route.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.3/angular-sanitize.js"></script>
<script src="{{ asset('js/jquery.tablesorter.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/fullcalendar.js') }}"></script>
<script src="{{ asset('js/jasny-bs.js') }}"></script>
<script src="{{ asset('js/navbar-toggle.js') }}"></script>
<script>
	var app = angular.module('application', ['ngSanitize']);

	CKEDITOR.env.isCompatible = true;
</script>
</body>
</html>
