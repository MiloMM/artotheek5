@extends('app')
@section('content')

<div class="filter-edit-form">
<h2>Verander '{{ $filterItem->naam }}' naar:</h2>
{!! Form::open(['action' => ['FilterController@update', $filterItem->id], 'required', 'method' => 'put']) !!}
	{!! Form::text('naam', $filterItem->naam, ['class' => 'form-control custom-spacer']) !!} <br/>
	{!! Form::submit('Wijzigen', ['class' => 'btn btn-primary']) !!}
	<a class="btn btn-primary" href="/filters/{{ $filterItem->filter_id }}">Annuleren</a>
{!! Form::close() !!}
</div>
<script>
	function goBack()
	{
		window.history.back();
	}
</script>
@stop