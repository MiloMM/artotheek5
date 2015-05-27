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
						<div class="form-group" id="form-group-preview-img">
							<div class="col-md-12">
								<input type="file" name="image" class="form-control" style="display: none;">
								{!! Form::button('Selecteer Foto', ['class' => 'form-control btn btn-default', 'id' => 'btn-select-img', 'style' => 'margin-bottom: 70px;']) !!}
								<div id="image-editor">
									
								</div>
							</div>
						</div>
						<div class="progress">
						  <div id="progressbar-upload" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; margin-top: 50px;">
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

		$('#btn-select-img').click(function () {
			$('#form input[type=file]').click();
		});

		// User changed file
		$('#form input[type=file]').on('change', function () {
			// Is it more than 1 file?
			if ($(this)[0].files.length > 1) {
				// Tell user to upload only 1 file
				functions.showErrorBanner('Je mag maar een foto uploaden per kunstwerk.');
			} else {
				// Check if file is an image.
				if ($(this)[0].files[0] != undefined && $(this)[0].files[0].type.match('image/*')) {
					// Load img src from local machine, for darkroom
					var fr = new FileReader();
					fr.onload = function () {
						$('#image-editor').append('<img class="img-responsive">');
						if ($('.darkroom-container')) {
							$('.darkroom-container').remove();
						}
						$('#image-editor img').attr('src', fr.result);
						var darkroom = new Darkroom('#image-editor img', {
							plugins: {
								save: false
							}
						});
					}
					fr.readAsDataURL($(this)[0].files[0]);
					$(this).hide();
				} else {
					// File isnt a photo
					functions.showErrorBanner('Het bestand moet een foto zijn.');
					$(this).replaceWith($(this).val('').clone(true));
				}
			}
			
		});

		$('#form').submit(function (event) {
			event.preventDefault();
		});

		$('#btn-send').click(function () {
			var progressbar = $('#progressbar-upload');
			progressbar.attr('aria-valuenow', 0);
			progressbar.attr('style', 'width: ' + 0 + '%; margin-top: 50px;');

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
				
				if (xhr.status == 200 || xhr.status == 0) {
					var progressbar = $('#progressbar-upload');
					progressbar.html('geupload');

					functions.showSuccessBanner('Nieuw kunstwerk geupload');

				} else {
					functions.showErrorBanner('Er was een fout bij het aanmaken van een nieuw kunstwerk.');
				}
			}
			
			var canvas = $('.canvas-container .lower-canvas')[0];
			var dataURL = canvas.toDataURL('image/jpeg');
			var encoding = dataURL.split(',')[0];
			var base64 = dataURL.split(',')[1];

			var form = new FormData();
			form.append('_token', '{{ csrf_token() }}');
			form.append('_method', 'POST');
			form.append('title', $('#tbx-title').val());
			form.append('description', editor.getData());
			form.append('image-data-url', dataURL);
			form.append('tags', $('#tbx-tags').val());

			xhr.send(form);
		});
	});
</script>
@stop