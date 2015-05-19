@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">{{ $article->title }}</div>
	<div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<a href="#" class="btn btn-primary">Wijzig</a>
				<button href="#" class="btn btn-warning">Archiveer</button>
				<button href="#" class="btn btn-danger">Verwijder</button>
			</div>
		</div>
		{!! $article->content !!}
	</div>
</div>
<script>
	
</script>
@stop