@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">{{ $article->title }}</div>
	<div class="panel-body">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<a href="/news/{{ $article->slug }}/edit" class="btn btn-primary">Wijzig</a>
				@if ($article->state == 1)
					<button id="btnPublish" class="btn btn-success">Publiceer</button>
					<button id="btnArchive" style="display:none;" class="btn btn-warning">Archiveer</button>
				@else
					<button id="btnPublish" style="display:none;" class="btn btn-success">Publiceer</button>
					<button id="btnArchive" class="btn btn-warning">Archiveer</button>
				@endif
				<button id="btnRemove" class="btn btn-danger">Verwijder</button>
			</div>
		</div>
		{!! $article->content !!}
	</div>
</div>
<script>
	$(function () {
		$('#btnArchive').click(function () {
			var request = $.post('/news/{{ $article->id }}', {
				_token: '{{ csrf_token() }}',
				_method: 'PUT',
				title: '{{ $article->title }}',
				content: '{!! trim($article->content) !!}',
				state: 1
			});

			request.success(function (response) {
				functions.showSuccessBanner('Artikel gearchiveerd.');
				$('#btnPublish').fadeToggle(600);
				$('#btnArchive').fadeToggle(600);
			});
			request.error(function () {
				functions.showErrorBanner('error');
			});
		});
		$('#btnPublish').click(function () {
			var request = $.post('/news/{{ $article->id }}', {
				_token: '{{ csrf_token() }}',
				_method: 'PUT',
				title: '{{ $article->title }}',
				content: '{!! trim($article->content) !!}',
				state: 0
			});

			request.success(function (response) {
				functions.showSuccessBanner('Artikel gepubliceerd.');
				$('#btnArchive').fadeToggle(600);
				$('#btnPublish').fadeToggle(600);
			});
			request.error(function () {
				functions.showErrorBanner('error');
			});
		});
		$('#btnRemove').click(function () {
			if (confirm('Weet je zeker dat je dit artikel wilt verwijderen?')) {
				var request = $.post('/news/{{ $article->id }}', {
					_token: '{{ csrf_token() }}',
					_method: 'DELETE'
				});
				request.success(function (response) {
					functions.showSuccessBanner('Artikel verwijdert.', 800);
					setTimeout(function () {
						window.location.assign('/news');
					}, 2300);
				});
				request.error(function () {
					functions.showErrorBanner('error');
				});
			}
		});
	});
</script>
@stop