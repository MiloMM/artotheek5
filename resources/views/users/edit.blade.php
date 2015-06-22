@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Wijzig gebruikers profiel</div>
				<div class="panel-body">

					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form']) !!}
						<div class="form-group">
							{!! Form::label('Naam', null, ['class' => 'col-md-1 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-11">
								{!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'tbx-name']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('E-mail', null, ['class' => 'col-md-1 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-11">
								{!! Form::text('e-mail', $user->email, ['class' => 'form-control', 'id' => 'tbx-email']) !!}
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
	$('#form').submit(function (event) {
			event.preventDefault();
		});

		$('#btn-send').click(function () {
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/users/{{$user->slug}}');

			xhr.onload = function () {
				
				if (xhr.status == 200 || xhr.status == 0) {
					

					response = JSON.parse(xhr.response);
					var msg = "<ul>";
					$(response).each(function (k, v) {
						msg += "<li>" + v + "</li>";
					});
					msg += "</ul>";

					functions.showSuccessBanner(msg, 5000);

				} else {

					response = JSON.parse(xhr.response);
					var msg = "<ul>";
					$(response).each(function (k, v) {
						msg += "<li>" + v + "</li>";
					});
					msg += "</ul>";

					functions.showErrorBanner(msg);
				}
			}

			var form = new FormData();
			form.append('_token', '{{ csrf_token() }}');
			form.append('_method', 'PUT');
			form.append('name', $('#tbx-name').val());
			form.append('email', $('#tbx-email').val());


			xhr.send(form);
		});
</script>


@stop