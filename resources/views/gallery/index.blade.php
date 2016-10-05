@extends('app')
@section('content')
<div class="container-fluid" ng-controller="galleryController">
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
		<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Voeg toe</a>
		@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
			<a href="{{ action('ArtworkController@showArchived') }}" id="btnShowArchived" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i> Archief</a>
		@endif
		<hr>
	@endif
	
	<h1>Galerij</h1>
	<div class="flex-container">
	@foreach($artworks as $artwork)
		<div class="img-box">
			<a href="/artworks/{{ $artwork->slug }}">
				<img src="{{ $artwork->file }}" class="img-box-image" id="{{ $artwork->id }}">
			</a>
		</div>
	@endforeach
	</div>
</div>
@endsection