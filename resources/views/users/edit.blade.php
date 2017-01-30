@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Wijzig gebruikers profiel</div>
				<div class="panel-body">
					
					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form', 'enctype' => 'multipart/form-data', 'method' => 'put', 'action' => ['UserController@update', $user->slug]]) !!}
						<div class="form-group">
							{!! Form::label('Naam', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('name', $user->name, ['class' => 'form-control', 'id' => 'tbx-name', 'required' => 'required']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('E-mail', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('e-mail', $user->email, ['class' => 'form-control', 'id' => 'tbx-email', 'required' => 'required']) !!}
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
								{!! Form::input('number', 'school_year', $user->school_year, ['class' => 'form-control', 'id' => 'tbx-school_year', 'max' => '99', 'step' => '1']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Adres', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('delivery_address', $user->delivery_address, ['class' => 'form-control', 'id' => 'tbx-delivery_address', 'required' => 'required']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Postcode', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10">
								{!! Form::text('zip', $user->zip, ['class' => 'form-control', 'id' => 'tbx-zip', 'required' => 'required']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('Biografie', null, ['class' => 'control-label col-md-2']) !!}
							<div class="col-md-10">
								{!! Form::textarea('biography', $user->biography, ['class' => 'form-control', 'id' => 'textarea-biography']) !!}
							</div>
						</div>
						
						<div class="form-group">
							{!! Form::label('Profielfoto', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
							<div class="col-md-10" style="margin-bottom: 10px;">
								<img src="{{ $user->profile_picture }}" class="edit_profile_pic">
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-10">
								<i>Nieuwe foto: </i><input type="file" name="fileToUpload" id="fileToUpload">
							</div>
						</div>
						@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
							@if (Auth::user()->id != $user->id)
								<?php $display = "block"; ?>
							@else
								<?php $display = "none"; ?>
							@endif
								<div class="form-group" style="display: {{ $display }}">
									{!! Form::label('Rechten', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!}
									<div class="col-md-10">
										<input type="radio" value="1" name="privelege" <?php if ($user->privelege === 1) echo 'checked="checked"'; ?>> Gebruiker<br>
										<input type="radio" value="2" name="privelege" <?php if ($user->privelege === 2) echo 'checked="checked"'; ?>> Kunstenaar<br>
										<input type="radio" value="4" name="privelege" <?php if ($user->privelege === 4) echo 'checked="checked"'; ?>> Administrator
									</div>
								</div>
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
	$(function () {
		editor = CKEDITOR.replace('textarea-biography');
	});
	
	$('input[name="name"]').keypress(function() {
		if (this.value.length >= 100) {
			return false;
		}
	});
	
	$('input[name="e-mail"]').keypress(function() {
		if (this.value.length >= 125) {
			return false;
		}
	});
	
	$('input[name="telephone"]').keypress(function() {
		if (this.value.length >= 20) {
			return false;
		}
	});
	
	$('input[name="zip"]').keypress(function() {
		if (this.value.indexOf(' ') > -1) {
			if (this.value.length >= 7) {
				return false;
			}
		}
		else {
			if (this.value.length >= 6) {
				return false;
			}
		}
	});
	
	$('input[name="education"]').keypress(function() {
		if (this.value.length >= 75) {
			return false;
		}
	});
</script>


@stop
