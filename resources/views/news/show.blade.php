@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">{{ $article->title }}</div>
	<div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<a href="#" class="btn btn-primary">Wijzig</a>
				<button id="btnArchive" class="btn btn-warning">Archiveer</button>
				<button id="btnRemove" class="btn btn-danger">Verwijder</button>
			</div>
		</div>
		{!! $article->content !!}
	</div>
</div>
<script>
	$(function () {
		$('#btnArchive').click(function () {
			var request = $.post('/news', {
				_token: '{{ csrf_token() }}',
				_method: 'PUT',
				title: '{{ $article->title }}',
				content: '{!! trim($article->content) !!}',
				state: 0
			});

			request.success(function (response) {
				functions.showSuccesBanner('succes');
			});
			request.error(function () {
				functions.showErrorBanner('error');
			});
		});
	});
</script>
@stop