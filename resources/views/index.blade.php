@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-header">
		<div style="padding-left: 15px;"><h1 id='indexPageTitle'>Da Vinci Artotheek</h1></div>
	</div>
	<div class="panel-body">

	@if(isset($text->text))
		{!! $text->text !!}
	@endif

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
		<div class="newsItems-container">
			@foreach($news as $newsItem)
				<div class="newsItem col-md-6">
					<div class="newsItem-header">
						<a class="newsItem-title" href="/news/article/{{$newsItem->slug}}"><h4>{{ $newsItem->title }}</h4></a>
					</div>	
						{!! $newsItem->content !!}
				</div>
			@endforeach
		</div>
	</div>
</div>
@stop