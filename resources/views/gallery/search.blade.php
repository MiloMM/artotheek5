@extends('app')
@section('content')

	<?php
		if (count($searchResults) > 1 || count($searchResults) < 1) {
			$resultWord = "resultaten";
		}
		else {
			$resultWord = "resultaat";
		}
	?>
	<p style="text-align: center; font-size: 16px;">Uw zoekopdracht haalde <b>{{count($searchResults) }}</b> {{$resultWord}} op</p>

	<div class="searchResults">
		<ul>
			@if (empty($request->input('keyword')))
				<li><b>Trefwoord: </b><i>-</i> / </li>
			@else
				<li><b>Trefwoord: </b><i>{{ $request->input('keyword') }}</i> / </li>
			@endif
		
			<li><b>Kunstenaar: </b><i>{{ $artist['name'] }}</i> / </li>
			<li><b>Categorie: </b><i>{{ $request->input('categorie') }}</i> / </li>
			<li><b>Genre: </b><i>{{ $request->input('genre') }}</i> / </li>
			<li><b>Materiaal: </b><i>{{ $request->input('materiaal') }}</i> / </li>
			<li><b>Techniek: </b><i>{{ $request->input('techniek') }}</i></li>
		</ul>
	</div>
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