@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">Gallerij</div>
	<div class="panel-body">
		<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Voeg toe</a>
	</div>
</div>
<script>

</script>
@stop