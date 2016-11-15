@extends('app')
@section('content')
<div class="panel">
	<div class="filter-edit-form">
		<h1>De kunstenaar '{{ $artist->name }}' verwijderen</h1>
		<p>Weet u zeker dat u deze kunstenaar wil verwijderen? Het profiel/account waar deze aan gekoppeld is blijft bestaan.</p>
		{!! Form::open(['action' => ['ArtistController@destroy', $artist->id], 'required', 'method' => 'delete']) !!}
			
			{!! Form::radio('delete', 'delete') !!} Ja <br>
			{!! Form::radio('delete', 'deleteAll') !!} Ja, en verwijder ook alle kunstwerken die bij deze kunstenaar horen<br>
			{!! Form::radio('delete', 'no', true) !!} Nee
			<div class="submit-div">
				{!! Form::submit('Verder', ['class' => 'btn btn-primary']) !!}
				<a class="btn btn-primary" href="/artists">Annuleren</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>

@stop
