@extends('app')
@section('content')

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="/artworks/{{ $artwork->slug }}/edit" class="btn btn-warning">Wijzig</a>
			@if(Auth::check())
				<a href="/reservation/create/{{ $artwork->id }}" class="btn btn-info">Reserveer</a>
			@endif
			<div  style="float: right;" class="fb-like" data-href="http://www.artotheekdavinci.nl/artworks/{{ $artwork->slug }}" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
		</div>
		<div class="panel-heading">
			{{ $artwork->title }}	
		</div>
		<img src="/{{ $artwork->file }}" alt="" style="width: 100%; max-width: 500px; max-height: 700px;">
		<div class="panel-body">{!! $artwork->description !!}</div>
		<p class="tag-paragraph"> 
			@foreach($tagArray as $tag)
				<span class="glyphicon glyphicon-tag"></span><a href="/tags/{{$tag}}">{{ $tag }}</a>
			@endforeach
		</p>
	</div>
</div>


@stop