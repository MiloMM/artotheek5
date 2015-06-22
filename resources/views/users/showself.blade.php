@extends('app')
@section('content')

<div class="panel panel-default">
<div class="panel-heading">
	<h1>Gebruikers Profiel</h1><a class="btn btn-warning" href="{{$user->slug}}/edit">Wijzig</a>
</div>
	<div class="panel-body">
		<p>Naam: {{$user->name}}</p>
		<p>E-mail: {{$user->email}}</p>
		<p>Lid sinds: {{$user->created_at}}</p>
	</div>
	
</div>

@stop