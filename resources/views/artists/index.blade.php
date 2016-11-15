@extends('app')
@section('content')
<div class="panel">
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
		<a href="{{ action('ArtistController@create') }}" id="btnAdd" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Voeg toe</a>
		<hr>
	@endif
	<div class="panel-heading">
		<h1>Kunstenaars</h1>
	</div>
	<div class="panel-body">
		@foreach($artists as $artist)
			<a href="{{$artist->profileLink}}">{{$artist->name}}</a>
			<a class="fa fa-pencil-square-o filter-options" href="/artists/edit/{{ $artist->id }}"title="Wijzigen"></a>
			<a class="fa fa-trash filter-options" href="/artists/delete/{{ $artist->id }}" onclick="return confirm('Weet u zeker dat u \'{{$artist->name}}\' wilt verwijderen?')" title="Verwijderen"></a>
			<br>
		@endforeach
	</div>
</div>

@stop
