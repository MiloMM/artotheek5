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
							{!! Form::label('Naam', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'tbx-name']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('E-mail', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('e-mail', $user->email, ['class' => 'form-control', 'id' => 'tbx-email']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Telefoon Nummer', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('telephone', $user->telephone, ['class' => 'form-control', 'id' => 'tbx-telephone']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Opleiding / Sector', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('education', $user->education, ['class' => 'form-control', 'id' => 'tbx-education']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Leerjaar', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::input('number', 'school_year', $user->school_year, ['class' => 'form-control', 'id' => 'tbx-school_year']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Adres', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('delivery_address', $user->delivery_address, ['class' => 'form-control', 'id' => 'tbx-delivery_address']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Postcode', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('zip', $user->zip, ['class' => 'form-control', 'id' => 'tbx-zip']) !!}
							</div>
						</div>
						@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
							@if (Auth::user()->id != $user->id)
								<div class="form-group">
									{!! Form::label('Rechten', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
									<div class="col-md-10">
										<input type="radio" value="1" name="privelege" <?php if ($user->privelege === 1) echo 'checked="checked"'; ?>> Gebruiker<br>
										<input type="radio" value="2" name="privelege" <?php if ($user->privelege === 2) echo 'checked="checked"'; ?>> Kunstenaar<br>
										<input type="radio" value="4" name="privelege" <?php if ($user->privelege === 4) echo 'checked="checked"'; ?>> Administrator
									</div>
								</div>
							@endif
						@endif
						<div class="form-group">
								<div class="col-md-2 col-md-offset-2">
									{!! Form::submit('Wijzigen', ['class' => 'btn btn-success form-control', 'id' => 'btn-send']) !!}
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
			form.append('telephone', $('#tbx-telephone').val());
			form.append('education', $('#tbx-education').val());
			form.append('school_year', $('#tbx-school_year').val());
			form.append('delivery_address', $('#tbx-delivery_address').val());
			form.append('zip', $('#tbx-zip').val());
			form.append('privelege', $('input[name="privelege"]:checked').val());

			xhr.send(form);
			@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
				window.location.href = "/users";
			@else
				window.location.href = "/myprofile";
			@endif
		});
</script>


@stop
