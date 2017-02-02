@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-header">
		<div style="padding-left: 15px;"><h1 id='indexPageTitle'>Da Vinci Artotheek</h1></div>
	</div>
	<div class="panel-body">

	{!! $text->text !!}

	<div class="panel-header">
		<p style="color:black; margin-top: 25px;"><h4>Recent toegevoegd:</h4></p>
	</div>
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
</div>
@stop