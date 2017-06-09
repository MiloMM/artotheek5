@extends('app')

@section('content')
	<h1>Over de Da Vinci Galleria</h1>
	
	@if(isset($text->text))
		{!! $text->text !!}
	@endif

@stop