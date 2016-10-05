@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Wijzig het kunstwerk: {{ $artwork->title }}</div>
				<div class="panel-body">

					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form']) !!}
						<div class="form-group">
							{!! Form::label('Titel', null, ['class' => 'col-md-1 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-11">
								{!! Form::text('title', $artwork->title, ['class' => 'form-control', 'id' => 'tbx-title']) !!}
							</div>
						</div>
						<div class="form-group" id="form-group-preview-img">
							<div class="col-md-12">
								<div id="image-editor">
									<!-- Load images instantly -->
									<img src="{{ asset($artwork->file) }}" alt="" class="editpage-img">
								</div>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Omschrijving', null, ['class' => 'control-label col-md-1']) !!}
							<div class="col-md-12">
								{!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'textarea-description']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Kunstenaar', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('artist', null, ['class' => 'form-control', 'id' => 'tbx-artist']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Techniek', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('technique', null, ['class' => 'form-control', 'id' => 'tbx-technique']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Colour', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::select('colour', array('rood' => 'Rood', 'blauw' => 'Blauw'), 'Rood', ['class' => 'form-control', 'id' => 'tbx-colour']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Materiaal', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::select('material', array('hout' => 'Hout', 'metaal' => 'Metaal'), 'Hout', ['class' => 'form-control', 'id' => 'tbx-material']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Categorie', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('category', null, ['class' => 'form-control', 'id' => 'tbx-category']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Formaat', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('size', null, ['class' => 'form-control', 'id' => 'tbx-size']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Prijs', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('price', null, ['class' => 'form-control', 'id' => 'tbx-price']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Tags', null, ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								<input id="tbx-tags" type="text" class="form-control" value="{!! $artwork->tagsToTagsinput() !!}" placeholder="Voeg tags toe..." data-role="tagsinput">
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Publiceer', null, ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::checkbox('publish', true , ['class' => 'col-md-4 form-control']) !!}
							</div>
						</div>

						<div class="progress">
						  <div id="progressbar-upload" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; margin-top: 50px;">
						    0%
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
	$(function () {
		var editor = CKEDITOR.replace('textarea-description');	

		$('#form').submit(function (event) {  
			event.preventDefault();
		});

		$('#btn-send').click(function () {

			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/artworks/{{$artwork->id}}');

			xhr.upload.onprogress = function (e) {
				var percentage = (e.loaded / e.total * 100);
				var progressbar = $('#progressbar-upload');
				progressbar.attr('aria-valuenow', percentage);
				progressbar.attr('style', 'width: ' + percentage + '%;');
				progressbar.html(percentage + '%');
			}
			
			var canvas = $('.canvas-container .lower-canvas')[0];
			var dataURL = canvas.toDataURL('image/jpeg');
			var encoding = dataURL.split(',')[0];
			var base64 = dataURL.split(',')[1];

			var form = new FormData();
			form.append('_token', '{{ csrf_token() }}');
			form.append('_method', 'POST');
			form.append('title', $('#tbx-title').val());
			form.append('artist', $('#tbx-artist').val());
			form.append('technique', $('#tbx-technique').val());
			form.append('colour', $('#tbx-colour').val());
			form.append('material', $('#tbx-material').val());
			form.append('category', $('#tbx-category').val());
			form.append('size', $('#tbx-size').val());
			form.append('price', $('#tbx-price').val());
			form.append('description', editor.getData());
			form.append('publish', $('input[name=publish]')[0].checked);
			form.append('tags', $('#tbx-tags').val());

			xhr.send(form);
		});
	});
</script>
@stop