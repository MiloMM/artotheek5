@extends('app')
@section('content')

<div id="imagePopup">
	<span class="glyphicon glyphicon-remove custom_glyphicon-remove"></span>
	<img src="{{ $reservation->file }}" alt="" id="imagePopupImage">
</div>

<div class="col-md-8 col-md-offset-2 artworkPage">
	<div class="panel-default">
		<div class="artworkTitleBar panel-heading">
			<h2 class="artworkTitle">{{ $reservation->title }}</h2>
			<div class="artworkOptions">
				@if(Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
					<a href="/reservation/edit/{{ $reservation->id }}" title="Kunstwerk wijzigen">
						<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
					</a>
				@endif
			</div>
		</div>
		<div class="col-md-4" style="padding: 0; margin-top: 10px;">
			<img class="artworkImage" src="/{{ $reservation->file }}" alt="">
			<i>Klik op de afbeelding om te vergroten.</i>
		</div>
		<div class="col-md-8 artworkInfo" style="margin-top: 10px;">
			<div class="artworkInfoTable">
				<h4><b>Reservering info</b></h4>
					<div class="col-md-3"><b>Artiest</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->name }}</div>
					<div class="col-md-3"><b>Startdatum</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->from_date }}</div>
					<div class="col-md-3"><b>Einddatum</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->to_date }}</div>
					<div class="col-md-3"><b>Afleveradres</b></div>
					<div class="col-md-9" style="height: 20px; margin-bottom: 10px;">{{ $reservation->delivery_adress }}</div>
				<h4><b>Kunstwerk info</b></h4>
					<div class="col-md-3"><b>Description</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->description }}</div>
					<div class="col-md-3"><b>Techniek</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->technique }}</div>
					<div class="col-md-3"><b>Categorie</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->category }}</div>
					<div class="col-md-3"><b>Grootte</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->size }}</div>
					<div class="col-md-3"><b>Prijs</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->price }}</div>
					<div class="col-md-3"><b>Kleur</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->colour }}</div>
					<div class="col-md-3"><b>Materiaal</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->material }}</div>
					<div class="col-md-3"><b>Genre</b></div>
					<div class="col-md-9" style="height: 20px;">{{ $reservation->genre }}</div>
			</div>
		</div>
	</div>
</div>
@stop


