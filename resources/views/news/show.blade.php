@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">{{ $article->title }}</div>
	<div class="panel-body">{!! $article->content !!}</div>
</div>
@stop