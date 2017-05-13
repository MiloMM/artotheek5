@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
			@if(session('succesMsg'))
				<div class="alert alert-success"> {!!session('succesMsg')!!} </div>
			@endif
				<div class="panel-heading">Tekst van pagina's aanpassen</div>
				<div class="panel-body">

					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form', 'action' => ['PagesController@updatePagesText']]) !!}
						<div class="form-group">
							{!! Form::label('Home pagina', null, ['class' => 'control-label']) !!}
							@if(isset($text['home']->text))
								{!! Form::textarea('home', $text['home']->text, ['class' => 'form-control', 'id' => 'textarea-home']) !!}
							@else
								{!! Form::textarea('home', '', ['class' => 'form-control', 'id' => 'textarea-home']) !!}
							@endif
						</div>
						<div class="form-group">
							{!! Form::label('Over Da Vinci Galleria', null, ['class' => 'control-label']) !!}
							@if(isset($text['about']->text))
								{!! Form::textarea('about', $text['about']->text, ['class' => 'form-control', 'id' => 'textarea-about']) !!}
							@else
								{!! Form::textarea('about', '', ['class' => 'form-control', 'id' => 'textarea-about']) !!}
							@endif
						</div>
						<div class="form-group">
							{!! Form::label('Uitleenvoorwaarden', null, ['class' => 'control-label']) !!}
							@if(isset($text['conditions']->text))
								{!! Form::textarea('conditions', $text['conditions']->text, ['class' => 'form-control', 'id' => 'textarea-conditions']) !!}
							@else
								{!! Form::textarea('conditions', '', ['class' => 'form-control', 'id' => 'textarea-conditions']) !!}
							@endif
						</div>
						<div class="form-group">
							{!! Form::submit('Aanpassen', ['class' => 'btn btn-success form-control', 'id' => 'btn-send', 'style' => 'width:150px;float:left;']) !!}
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function () {
		var editor1 = CKEDITOR.replace('textarea-home');
		var editor2 = CKEDITOR.replace('textarea-about');
		var editor3 = CKEDITOR.replace('textarea-conditions');
	});
</script>
@stop
