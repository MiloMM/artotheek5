@extends('app')
@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="/artworks/{{ $artwork->slug }}/edit" class="btn btn-warning">Wijzig</a>
			@if(Auth::check())
				<a href="/reservation/create/{{ $artwork->id }}" class="btn btn-info">Reserveer</a>
			@endif
		</div>
		<div class="panel-heading">
			{{ $artwork->title }}	
		</div>
		<div class="panel-body">{!! $artwork->description !!}</div>
		<p class="tag-paragraph"><span class="glyphicon glyphicon-tag"></span>: 
			@foreach($tagArray as $tag)
				<a href="/tags/{{$tag}}">	{{ $tag }} </a>
			@endforeach
		</p>
		<img src="/{{ $artwork->file }}" alt="" style="width: 100%">
	</div>
</div>



@stop