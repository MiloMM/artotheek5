@extends('app')
@section('content')
<div class="container-fluid" ng-controller="galleryController">
	<a href="{{ action('ArtworkController@index') }}" id="btnShowPublished" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Naar de galerij</a>
	<h1>Het archief</h1>
	
	<hr>
	
	 <div class="" id="image-container">
		@foreach($artworks as $artwork)
			<div class="img-box">
				<a href="/artworks/{{ $artwork->slug }}">
					<img src="/{{ $artwork->file }}" class="img-box-image" id="{{ $artwork->id }}">
				</a>
			</div>
		@endforeach
	</div>
</div>

@endsection