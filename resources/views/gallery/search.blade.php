@extends('app')
@section('content')
	<p style="text-align: center;border-bottom: 1px solid #e7e7e7; padding-bottom: 10px;font-size: 16px;">Uw zoekquery haalde <b>{{count($result[1] ) }}</b> resultaten op</p>

	@foreach ($result[1] as $results)
		<div class="col-md-3">
			<a href="/artworks/{{ $results->slug }}" class="custom-gallery-link">
				<img class="col-md-12" src="/{{$results->file}}" style="margin-bottom: 10px;" />
				<h3 style="text-align: center;color:black">{{$results->title}}</h3>
			</a>
		</div>
	@endforeach
@endsection