@extends('app')
@section('content')
<div class="panel">
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) 
		<a href="{{ action('ArtistController@create') }}" id="btnAdd" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Voeg toe</a>
		<hr>
	@endif
	<div class="panel-heading">
		<h1>Kunstenaars</h1>
	</div>
	<div class="panel-body">
		@foreach($artists as $artist)
			<a href="{{ $artist->profileLink }}" class="artist">{{$artist->name}}</a>
			
			@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
				<a class="fa fa-pencil-square-o filter-options" href="/artists/edit/{{ $artist->id }}"title="Wijzigen"></a>
				<a class="fa fa-trash filter-options" href="/artists/delete/{{ $artist->id }}" title="Verwijderen"></a>
			@endif
			<br>
		@endforeach
	</div>
</div>

@stop
