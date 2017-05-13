@extends('app')

@section('content')
	<h1>Uitleenvoorwaarden</h1>
	
	@if(isset($text->text))
		{!! $text->text !!}
	@endif
	
@stop