@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Wijzig het kunstwerk: {{ $artwork->title }}</div>
				<div class="panel-body">

					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form', 'method' => 'put', 'action' => ['ArtworkController@update', $artwork->id]]) !!}
						<div class="form-group">
							{!! Form::label('Titel', null, ['class' => 'col-md-1 control-label']) !!}
							<div class="col-md-11">
								{!! Form::text('title', $artwork->title, ['class' => 'form-control', 'id' => 'tbx-title']) !!}
							</div>
						</div>
						<div class="form-group" id="form-group-preview-img">
							<div class="col-md-12">
								<div id="image-editor">
									<!-- Load image instantly -->
									<img src="{{ asset($artwork->file) }}" alt="" class="editpage-img">
								</div>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Omschrijving', null, ['class' => 'control-label col-md-1']) !!}
							<div class="col-md-12">
								{!! Form::textarea('description', $artwork->description, ['class' => 'form-control', 'id' => 'textarea-description']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Kunstenaar', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<select class="select2-select form-control" id="tbx-artist" name="artist" placeholder="Kies een kunstenaar">
								<option value="">Leeg laten</option>
								@foreach ($artists as $artist)
									<?php $selected = ($artwork->artist == $artist->id) ? "selected" : ""; ?>
									<option value="{{ $artist->id }}" {{ $selected }}>{{ $artist->name }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Techniek', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<select class="form-control select2-select" id="tbx-technique" name="technique">
								<option value="">Leeg laten</option>
								@foreach ($techniques as $technique)
									<?php $selected = ($artwork->technique == $technique->naam) ? "selected" : ""; ?>
									<option value="{{ $technique->naam }}" {{ $selected }}>{{ $technique->naam }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('kleur', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<select class="form-control select2-select" id="tbx-colour" name="colour">
								<option value="">Leeg laten</option>
								@foreach ($colours as $colour)
									<?php $selected = ($artwork->colour == $colour->naam) ? "selected" : ""; ?>
									<option value="{{ $colour->naam }}" {{ $selected }}>{{ $colour->naam }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Materiaal', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<select class="form-control select2-select" id="tbx-material" name="material">
								<option value="">Leeg laten</option>
								@foreach ($materials as $material)
									<?php $selected = ($artwork->material == $material->naam) ? "selected" : ""; ?>
									<option value="{{ $material->naam }}" {{ $selected }}>{{ $material->naam }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Categorie', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<select class="form-control select2-select" id="tbx-category" name="category">
								<option value="">Leeg laten</option>
								@foreach ($categories as $category)
									<?php $selected = ($artwork->category == $category->naam) ? "selected" : ""; ?>
									<option value="{{ $category->naam }}" {{ $selected }}>{{ $category->naam }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Genre', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:left']) !!}
							<div class="col-md-10">
								<select class="form-control select2-select" id="tbx-genre" name="genre">
								<option value="">Leeg laten</option>
								@foreach ($genres as $genre)
									<?php $selected = ($artwork->genre == $genre->naam) ? "selected" : ""; ?>
									<option value="{{ $genre->naam }}" {{ $selected }}>{{ $genre->naam }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Formaat', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								<select class="form-control select2-select" id="tbx-size" name="size">
								<option value="">Leeg laten</option>
								@foreach ($formats as $format)
									<?php $selected = ($artwork->size == $format) ? "selected" : ""; ?>
									<option value="{{ $format }}" {{ $selected }}>{{ $format }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Prijs', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10">
								{!! Form::text('price', $artwork->price, ['class' => 'form-control', 'id' => 'tbx-price']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Tags', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-10" id="tag-box">
								<input id="tbx-tags" type="text" class="form-control" value="{{ $artwork->tagsToTagsInput() }}" placeholder="Voeg tags toe..." name="tags" data-role="tagsinput">
							</div>
						</div>
						<div class="form-group" style="display:none">
							{!! Form::label('Oude tags', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-6" id="old-tags-box">
								<input id="old-tags" type="text" class="form-control" value="{{ $artwork->tagsToTagsInput() }}" name="old-tags" data-role="tagsinput">
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Publiceer', null, ['class' => 'col-md-2 control-label']) !!}
							<div class="col-md-6">
								<?php $checked = ($artwork->state === 1) ? false : true ?>
								{!! Form::checkbox('publish', false, $checked) !!}
							</div>
						</div>

						<div class="progress">
						  <div id="progressbar-upload" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; margin-top: 50px;">
						    0%
						  </div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-3">
								{!! Form::submit('Aanpassen', ['class' => 'btn btn-success form-control', 'id' => 'btn-send']) !!}
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
		$(".select2-select").select2();
	});

	$('#tag-box').change(function() {
		var tags = $('#tag-box .tagText');
		var tagString = "";

		for (var i = 0; i < tags.length; i++) {
			tagString += tags[i].innerHTML + ',';
		}

		tagString = tagString.substring(0, tagString.length - 1);
		$('#tbx-tags').attr('value', tagString);
	});
</script>
@stop
