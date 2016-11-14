@extends('app')
@section('content')
<div class="panel">
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
		<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Voeg toe</a>
		<hr>
	@endif
	<div class="panel-heading">
		<h1>Kunstenaars</h1>
	</div>
	<div class="panel-body">
		@foreach($artists as $artist)
			<a href="{{$artist->profileLink}}">{{$artist->name}}</a>
			<br>
		@endforeach
	</div>
</div>

@stop
