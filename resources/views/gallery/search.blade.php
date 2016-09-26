@extends('app')
@section('content')
	<p style="text-align: center;border-bottom: 1px solid #e7e7e7; padding-bottom: 10px;font-size: 16px;">Uw zoekopdracht haalde <b>{{count($result[1] ) }}</b> resultaten op</p>

	@foreach ($result[1] as $results)
		<div class="search-img">
			<a href="/artworks/{{ $results->slug }}" class="custom-gallery-link">
				<img class="" src="/{{$results->file}}" style="margin-bottom: 10px;" />
				<h3>{{$results->title}}</h3>
			</a>
		</div>
	@endforeach
@endsection