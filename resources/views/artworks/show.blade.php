@extends('app')
@section('content')
<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
			<a href="/artwork/{{ $artwork->slug }}/edit" class="btn btn-warning">Wijzig</a>
			<button id="btnArchive" class="btn btn-danger">Archiveer</button>
		<div class="panel-heading">{{ $artwork->title }}</div>
		<div class="panel-body">{!! $artwork->description !!}</div>
		<img src="/{{ $artwork->file }}" alt="" style="width: 100%">
	</div>
</div>

@stop