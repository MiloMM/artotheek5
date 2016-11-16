@extends('app')
@section('content')
	<p style="text-align: center;border-bottom: 1px solid #e7e7e7; padding-bottom: 10px;font-size: 16px;">Uw zoekopdracht haalde <b>{{count($result[1] ) }}</b> resultaten op</p>

	<div class="" id="image-container">
	@foreach ($result[1] as $results)
		<div class="img-box-search">
			<a href="/artworks/{{ $results->slug }}">
				<img class="img-box-image" src="/{{$results->file}}" />
				<h3>{{$results->title}}</h3>
			</a>
		</div>
	@endforeach
	<div>
@endsection