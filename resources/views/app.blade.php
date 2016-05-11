<?php
if( isset($_GET['filter']) )
{
	if($_GET['filter'] != 'geen'){
		$search="Zoek " . $_GET['filter'] . "...";
	}else{
		$search="Zoek...";
	}
}else{
	$search="Zoek...";
}
?>
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
	<ul style="margin-bottom:0px;" class="nav navmenu-nav">
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
	<ul class="nav navmenu-nav">
		<li><a href="/">Home</a></li>
		<li><a href="/gallery">Gallerij</a></li>
		<li><a href="/artists">Kustenaars</a></li>
		<li><a href="/reservations">Reserveringen</a></li>
	</ul>
</div>

<div class="canvas">
	<div class="navbar navbar-default navbar-fixed-top" style="position: relative;">
		<div class="custom-navbar-left" style="float: left;">
			<a href="/"><img src="{{ asset('images/logo.png') }}" alt="Logo Image" style="width: 80px; margin: 8px 0 0 10px;"></a>
		</div>
			
		<div class="custom-navbar-right" style="float: right;">
			<div style="margin-top: 8px; display: inline-block; float: left; margin-right: 10px;">
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				    Filter
				    	<span class="caret"></span>
				  	</button>
				  	<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				  		<li><a href="?filter=Fotografie / Multimedia">Fotografie / Multimedia</a></li>
						<li><a href="?filter=Kunstenaars">Kunstenaars</a></li>
						<li><a href="?filter=Tekeningen / Grafiek">Tekeningen / Grafiek</a></li>
						<li><a href="?filter=Meubels">Meubels</a></li>
						<li><a href="?filter=Onderwerp">Onderwerp</a></li>
						<li><a href="?filter=Schilderkunst">Schilderkunst</a></li>
						<li><a href="?filter=Ruimtelijk / Beelden">Ruimtelijk / Beelden</a></li>
						<li><a href="?filter=Vormgeving">Vormgeving</a></li>
						<li><a href="/">Geen filter</a></li>
					</ul>
<!--		<select class="form-control">
				<option>Fotografie / multimedia</option>
				<option>Kunstenaars</option>
				<option>Grafiek / tekeningen</option>
				<option>Meubels</option>
				<option>Onderwerp</option>
				<option>Schilderkunst</option>
				<option>Ruimtelijk / beelden / sculptuur</option>
				<option>Vormgeving</option>
			</select>
			<select class="form-control"> Fotografie / multimedia
				<option>Architectuur</option>
				<option>Dieren</option>
				<option>Figuren</option>
				<option>Genre</option>
				<option>Interieur</option>
				<option>Landschap</option>
				<option>Sculptuur / object / beeld</option>
				<option>Stilleven</option>
			</select>
			<select class="form-control"> Kunstenaars op alfabet
				...
			</select>
			<select class="form-control"> Grafiek / tekeningen
				<option>Abstract</option>
				<option>Architectuur</option>
				<option>Dieren</option>
				<option>Figuren</option>
				<option>Genre</option>
				<option>Interieur</option>
				<option>Landschap</option>
				<option>Meubel</option>
				<option>Sculptuur / object</option>
				<option>Stilleven</option>
				<option>Vormgeving</option>
			</select>
			<select class="form-control"> Meubels
				<option>Stoelen</option>
				<option>Tafels</option>
				<option>Banken</option>
				<option>Overige</option>
			</select>
			<select class="form-control"> Onderwerp
				<option>Abstract</option>
				<option>Architectuur</option>
				<option>Dieren</option>
				<option>Figuren</option>
				<option>Genre</option>
				<option>Interieur</option>
				<option>Landschap</option>
				<option>Meubel</option>
				<option>patronen</option>
				<option>Sculptuur / object</option>
				<option>Stilleven</option>
				<option>Vormgeving</option>
			</select>
			<select class="form-control"> Schilderkunst
				<option>Abstract</option>
				<option>Architectuur</option>
				<option>Dieren</option>
				<option>Figuren</option>
				<option>Genre</option>
				<option>Interieur</option>
				<option>Landschap</option>
				<option>Meubel</option>
				<option>Patronen</option>
				<option>Sculptuur / object</option>
				<option>Stilleven</option>
			</select>
			<select class="form-control"> Ruimtelijk / beelden / sculptuur
				<option>Abstract</option>
				<option>Dieren</option>
				<option>Figuren</option>
			</select>
			<select class="form-control"> Vormgeving
				<option>Letters</option>
				<option>Vormen</option>
			</select>
-->	
				</div>
			</div>
			<button id="customSearchControlBtn" class="btn btn-default" style="float: left; margin-top: 9px; padding: 5px 15px 5px 15px;">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		    <button type="button" id="custom_navbar_toggle" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		    </button>
		</div>
	</div>

	<div id="customSearchControlDiv" margin-top="5px">
	<form class="form-horizontal" role="form" method="GET" action="{{ url('/gallery/search') }}">
		<!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
		
		
	
		<div class="col-md-8 col-md-offset-2">
			<div class="row custom-searchbar-row">
				<label class="custom-searchbar-label">Kunstenaar</label>
				<select name="kunstenaar" class="custom-select-class-large">
					<option value="">Alle kunstenaars</option>
					<option>Alfred Jodocus Kwak</option>
					<option>Friedrich Nietzsche</option>
				</select>
				<label class="custom-searchbar-label-small">Kleur</label>
				<select name="kleur" class="custom-select-class-small">
					<option value="">Alle kleuren</option>
					<option>Rood</option>
					<option>Blauw</option>
					<option>Geel</option>
				</select>
				<label class="custom-searchbar-label">Trefwoorden</label>
			</div>
			<div class="row custom-searchbar-row">
				<label class="custom-searchbar-label">Onderwerp</label>
				<select name="onderwerp" class="custom-select-class-large">
					<option value="">Alle Onderwerpen</option>
					<option>Eten</option>
					<option>Dieren</option>
				</select>
				<label class="custom-searchbar-label-small">Grootte</label>
				<input name="grootte" class="custom-textfield-class-small" placeholder="Voorbeeld: 20 x 20" />
				<input class="custom-textfield-class-large" name="keyword" type="text" placeholder="<?=$search;?>" required />
			</div>
			<div class="row custom-searchbar-row">
				<label class="custom-searchbar-label">Materiaal</label>
				<select name="materiaal" class="custom-select-class-large">
					<option value="">Alle Materialen</option>
					<option>Hout</option>
					<option>Metaal</option>
				</select>
				<label class="custom-searchbar-label-small">Techniek</label>
				<select name="techniek" class="custom-select-class-small">
					<option value="">Alle Technieken</option>
					<option>Airbrush</option>
					<option>Impasto</option>
					<option>Penseeltekening</option>
				</select>
				<button class="custom-searchbar-button" type="submit">Zoek</button>
			</div>
		</div>
	</form>
	</div>

	<div class="container">
		@yield('content')
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
