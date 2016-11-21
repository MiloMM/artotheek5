@extends('app')
@section('content')
	<p style="text-align: center;border-bottom: 1px solid #e7e7e7; padding-bottom: 10px;font-size: 16px;">Uw zoekopdracht haalde <b>{{count($searchResults ) }}</b> resultaten op</p>

	<div class="" id="image-container">
	@foreach ($searchResults as $result)
		<div class="img-box-search">
			<a href="/artworks/{{ $result->slug }}">
				<img class="img-box-image" src="/{{$result->file}}" />
				<h3>{{$result->title}}</h3>
			</a>
		</div>
	@endforeach
	<div>
@endsection