@extends('app')
@section('content')

<div class="panel panel-default">
<div class="panel-heading">
	<h1>Mijn Profiel</h1><a class="btn btn-warning profileEditButton" href="{{$user->slug}}/edit">Wijzig</a>
</div>
	<div class="container profileDetails">
		<div class="col-md-6">
			<div class="col-md-3"><b>Naam</b></div>
			<div class="col-md-9">{{$user->name}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Lid sinds</b></div>
			<div class="col-md-9">{{$user->created_at}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>E-mail</b></div>
			<div class="col-md-9">{{$user->email}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Telefoon nummer</b></div>
			<div class="col-md-9">{{$user->telephone}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Opleiding / Sector</b></div>
			<div class="col-md-9">{{$user->education}}</div>
		</div>	
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Leerjaar</b></div>
			<div class="col-md-9">{{$user->school_year}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Overzicht werk</b></div>
			<div class="col-md-9">{{$user->work_summary}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Kostenplaatje</b></div>
			<div class="col-md-9">{{$user->price}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Bezorg adres</b></div>
			<div class="col-md-9">{{$user->delivery_address}}</div>
		</div>
		
		<div class="col-md-6">
			<div class="col-md-3"><b>Postcode</b></div>
			<div class="col-md-9">{{$user->zip}}</div>
		</div>
	</div>
</div>

<h4>Kunstwerken</h4>
@if (count($artworks) > 0)
	@foreach ($artworks as $artwork)
	<div class="img-box-search">
		<a href="/artworks/{{ $artwork->slug }}">
			<img class="img-box-image" src="/{{$artwork->file}}" />
			<h3>{{$artwork->title}}</h3>
		</a>
	</div>
	@endforeach
@else
	<i>Geen</i>
@endif

@stop
