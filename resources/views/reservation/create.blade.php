<?php setlocale (LC_TIME, "Dutch"); ?>

@extends('app')
@section('content')

<div class="panel panel-default">
	
	<div class="panel-heading">
		<h1>Het kunstwerk '{{ $artwork->title }}' reserveren</h1>
	</div>
	<div class="panel-body">
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'form']) !!}
      <div class="form-group"> 
        <div class="form-group"> 
          {!! Form::label('Naam:', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!} 
          {!! Form::input('text', 'client', null, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        </div> 
        <div class="form-group"> 
          {!! Form::label('Bedrijf:', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!} 
          {!! Form::input('text', 'company', null, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;']) !!} 
        </div> 
        <div class="form-group"> 
          {!! Form::label('Vanaf:', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!} 
          {!! Form::input('date', 'from-date', null, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        </div> 
        <div class="form-group">   
          {!! Form::label('Tot:', null, ['class' => 'col-md-2 control-label', 'style' => 'text-align:center']) !!} 
     	   {!! Form::input('date', 'to-date', null, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        </div> 
        <div class="form-group"> 
          {!! Form::label('Aflever adres', null, ['class' => 'col-md-2 control-label', 'style' => 'text-align:center']) !!} 
          {!! Form::input('text', 'delivery_adress', null, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        </div> 
				<div class="form-group">
					{!! Form::label('', null, ['class' => 'col-md-2 control-label', 'style' => 'text-align:center']) !!}
					{!! Form::submit('Verstuur', ['class' => 'btn btn-success', 'id' => 'btn-send', 'style' => 'width: 150px;']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
<script>
	var date = new Date();

	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();

	if (month < 10) month = "0" + month;
	if (day < 10) day = "0" + day;

	var today = year + "-" + month + "-" + day;

	$(function() {
    	$("input[name='from-date']").val(today);
    	$("input[name='to-date']").val(today);

	});

	$('#form').submit(function (event) {
			event.preventDefault();
		});

		$('#btn-send').click(function () {
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/reservation');

			xhr.onload = function () {
				
				if (xhr.status == 200 || xhr.status == 0) {
					

					response = JSON.parse(xhr.response);
					var msg = "<ul>";
					$(response).each(function (k, v) {
						msg += "<li>" + v + "</li>";
					});
					msg += "</ul>";
					
					window.location.href = "/reservations";
					
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
			form.append('_method', 'POST');
			form.append('client', $('[name="client"]').val()); 
      		form.append('company', $('[name="company"]').val()); 
			form.append('from-date', $('[name="from-date"]').val());
			form.append('to-date', $('[name="to-date"]').val());
			form.append('delivery_adress', $('[name="delivery_adress"]').val());
			form.append('artwork-id', '{{$artwork->id}}');
			form.append('artist-id', '{{Auth::user()->id}}');

			xhr.send(form);
		});
</script>
@stop