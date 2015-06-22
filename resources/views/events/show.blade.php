@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">{{ $event->title }}</div>
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<a href="/events/{{ $event->slug }}/edit" class="btn btn-primary">Wijzig</a>
				<button id="btnRemove" class="btn btn-danger">Verwijder</button>
			</div>
		</div>
		{!! $event->content !!}
		<hr>
		<p class="tag-paragraph">
			@foreach($tagArray as $tag)
				<span class="glyphicon glyphicon-tag"></span><a href="/tags/{{$tag}}">{{ $tag }}</a>
			@endforeach
		</p>
	</div>
</div>
<script>
	$(function () {
		$('#btnArchive').click(function () {
			var request = $.post('/events/{{ $event->id }}', {
				_token: '{{ csrf_token() }}',
				_method: 'PUT',
				title: '{{ $event->title }}',
				content: '{!! trim($event->content) !!}',
				state: 1
			});

			request.success(function (response) {
				functions.showSuccessBanner('Evenement gearchiveerd.');
				$('#btnPublish').fadeToggle(600);
				$('#btnArchive').fadeToggle(600);
			});
			request.error(function () {
				functions.showErrorBanner('error');
			});
		});
		$('#btnPublish').click(function () {
			var request = $.post('/events/{{ $event->id }}', {
				_token: '{{ csrf_token() }}',
				_method: 'PUT',
				title: '{{ $event->title }}',
				content: '{!! trim($event->content) !!}',
				state: 0
			});

			request.success(function (response) {
				functions.showSuccessBanner('Evenement gepubliceerd.');
				$('#btnArchive').fadeToggle(600);
				$('#btnPublish').fadeToggle(600);
			});
			request.error(function () {
				functions.showErrorBanner('error');
			});
		});
		$('#btnRemove').click(function () {
			if (confirm('Weet je zeker dat je dit evenement wilt verwijderen?')) {
				var request = $.post('/events/{{ $event->id }}', {
					_token: '{{ csrf_token() }}',
					_method: 'DELETE'
				});
				request.success(function (response) {
					functions.showSuccessBanner('Evenement verwijderd.', 800);
					setTimeout(function () {
						window.location.assign('/events');
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