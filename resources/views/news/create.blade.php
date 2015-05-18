@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nieuw artikel</div>
				<div class="panel-body">

					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form']) !!}
						<div class="form-group">
							{!! Form::label('Titel', null, ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('title', null, ['class' => 'form-control']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Inhoud', null, ['class' => 'control-label col-md-1']) !!}
							<div class="col-md-12">
								{!! Form::textarea('content', null, ['class' => 'form-control', 'id' => 'textarea-content']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Tags', null, ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								<input type="text" class="form-control" value="" placeholder="Voeg tags toe..." data-role="tagsinput">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
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
		CKEDITOR.replace('textarea-content');
		$('#form').submit(function (event) { 
			event.preventDefault(); 
			
			var request = $.post('/users', {
				_method: 'POST',
				_token: '{{ csrf_token() }}',
				form: $('#form').serialize()
			});

			console.log(request);

		});
		// 	

		// 	request.success(function () {
		// 		alert('gl');
		// 	});

		// 	request.error(function () {
		// 		alert('fail');
		// 	});
		// });
	});
</script>
@stop