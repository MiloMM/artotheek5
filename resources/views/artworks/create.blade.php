@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nieuw Kunstwerk</div>
				<div class="panel-body">

					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form']) !!}
						<div class="form-group">
							{!! Form::label('Titel', null, ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('title', null, ['class' => 'form-control', 'id' => 'tbx-title']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Descriptie', null, ['class' => 'control-label col-md-1']) !!}
							<div class="col-md-12">
								{!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'textarea-description']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Foto', null, ['class' => 'control-label col-md-4']) !!}
							<div class="col-md-6">
								{!! Form::file('image', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="progress">
						  <div id="progressbar-upload" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						    0%
						  </div>
						</div>
						<div class="form-group">
							{!! Form::label('Tags', null, ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								<input id="tbx-tags" type="text" class="form-control" value="" placeholder="Voeg tags toe..." data-role="tagsinput">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								{!! Form::submit('Verstuur', ['class' => 'btn btn-success form-control', 'id' => 'btn-send']) !!}
							</div>
						</div>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var editor = CKEDITOR.replace('textarea-description');
	$(function () {
		$('#form').submit(function (event) {
			event.preventDefault();

			var progressbar = $('#progressbar-upload');
			progressbar.attr('aria-valuenow', 0);
			progressbar.attr('style', 'width: ' + 0 + '%;');

			var file = document.querySelector('#form input[type=file]');
			// Check if file is a photo
			if (file.files[0] == undefined || !file.files[0].type.match('image/*')) {
				functions.showErrorBanner('Het bestand moet een foto zijn.');
				return;
			}

			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/artworks');

			xhr.upload.onprogress = function (e) {
				var percentage = (e.loaded / e.total * 100);
				var progressbar = $('#progressbar-upload');
				progressbar.attr('aria-valuenow', percentage);
				progressbar.attr('style', 'width: ' + percentage + '%;');
				progressbar.html(percentage + '%');
			}

			xhr.onload = function () {
				var progressbar = $('#progressbar-upload');
				progressbar.html('geupload');

				functions.showSuccessBanner('Nieuw kunstwerk geupload');
			}

			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
				alert(xhr.responseText);
			}

			var form = new FormData();
			form.append('_token', '{{ csrf_token() }}');
			form.append('_method', 'POST');
			form.append('title', $('#tbx-title').val());
			form.append('content', editor.getData());
			form.append('image', file.files[0]);
			form.append('tags', $('#tbx-tags').val());

			xhr.send(form);
		});
	});
</script>
@stop