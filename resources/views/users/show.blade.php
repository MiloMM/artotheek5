@extends('app')
@section('content')
<div class="panel panel-default">
<div class="panel-heading">
	<h1>Kunstenaar Profiel</h1>
</div>
		
	<div class="panel-body">
		<p>Naam: {{$user->name}}</p>
		<p>E-mail: {{$user->email}}</p>
		<p>Lid sinds: {{$user->created_at}}</p>
		<p>Telefoon nummer: {{$user->telephone}}</p>
		<p>Opleiding: {{$user->education}}</p>
		<p>Leerjaar: {{$user->school_year}}</p>

		<p>Overzicht werk: {{$user->overzicht_werk}}</p>
		<p>Kostenplaatje: {{$user->kostenplaatje}}</p>
		<p>Bezorg adres: {{$user->bezorg_adres}}</p>
		<p>Domein afdeling: {{$user->domein_afdeling}}</p>
	</div>
	
</div>
@stop