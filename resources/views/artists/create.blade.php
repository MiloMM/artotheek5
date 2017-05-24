@extends('app')
@section('content')
<div class="panel">
	<div class="filter-edit-form">
		<h1>Voeg een kunstenaar toe</h1>
		{!! Form::open(['action' => ['ArtistController@store'], 'required']) !!}
			<div>
				{!! Form::label('name', 'Naam') !!}
				{!! Form::text('name', null, ['class' => 'form-control custom-spacer', 'required' => 'required']) !!}
			</div>

			<div>
				{!! Form::label('name', 'Wilt u de kunstenaar koppelen aan een bestaand profiel/account?') !!}
				<select class="select2-select form-control" id="tbx-user" name="user">
					<option value="0">Nee</option>
				@foreach ($users as $user)
					<option value="{{ $user->id }}">Ja, aan het profiel van: {{ $user->name }}</option>
				@endforeach
				</select>
			</div>
			<br>

			<div class="submit-div">
				{!! Form::submit('Toevoegen', ['class' => 'btn btn-primary']) !!}
				<a class="btn btn-primary" href="/artists">Annuleren</a>
			</div>
		{!! Form::close() !!}
	</div>
</div>
<script>
	$(document).ready(function() {
		$(".select2-select").select2();
	});
</script>

@stop
