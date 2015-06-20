@extends('app')
@section('content')
<div class="panel">
	<div class="panel-heading">
		<h1>Kunstenaars</h1>
	</div>
	<div class="panel-body">
		@foreach($artists as $artist)
			<a href="/users/{{$artist->slug}}">{{$artist->name}}</a>
			<br>
		@endforeach
	</div>
</div>

@stop
