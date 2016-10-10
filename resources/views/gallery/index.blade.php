@extends('app')
@section('content')
<div class="container-fluid">
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
		<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Voeg toe</a>
		@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
			<a href="{{ action('ArtworkController@showArchived') }}" id="btnShowArchived" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i> Archief</a>
		@endif
		<hr>
	@endif
	
	<h1>Galerij</h1>
	<div class="flex-container" id="image-container">
	</div>
</div>
<script>
	imgContainer = document.getElementById('image-container');
	images = {!! $artworks !!};
	
	@foreach($artworks as $artwork)
		//console.log({!! $artwork !!});
		imgContainer.innerHTML += '<div class="img-box" id="{{ $artwork->id }}"><a href="/artworks/{{ $artwork->slug }}"><img src="{{ $artwork->file }}" class="img-box-image"></a></div>';
		
	@endforeach

</script>
@endsection