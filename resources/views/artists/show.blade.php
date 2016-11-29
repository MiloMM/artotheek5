@extends('app')

@section('content')
<br>
<div class="panel panel-default">
	
	<div class="container profileDetails">
		<i>Deze kunstenaar heeft nog geen profiel.</i>
	</div>
	<div class="col-md-12">
		<h1>Kunstwerken van {{ $artist->name }}</h1>
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
	</div>
</div>
@endsection