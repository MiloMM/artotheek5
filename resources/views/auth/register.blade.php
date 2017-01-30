@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
		@if (!empty(old('name')) || !empty(old('email')) || !empty(old('telephone')) || !empty(old('education')) || !empty(old('school_year')) || !empty(old('delivery_address')) || !empty(old('zip')))
			<div class="alert alert-success errorMsg">Weet je zeker dat je alle verplichte velden correct hebt ingevuld? Tip: Het wachtwoord moet uit minimaal 6 karakters bestaan.</div>	
		@endif
		Velden met * zijn verplicht.
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Naam *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Adres *</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Telefoonnummer</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="telephone" value="{{ old('telephone') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Opleiding / Sector</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="education" value="{{ old('education') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Leerjaar</label>
							<div class="col-md-6">
								<input type="number" class="form-control" name="school_year" value="{{ old('school_year') }}" max="99" step="1">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Adres *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="delivery_address" value="{{ old('delivery_address') }}" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Postcode *</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="zip" value="{{ old('zip') }}" required="required">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Wachtwoord *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" required="required">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Wachtwoord bevestigen *</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" required="required">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Registreer
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
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
	
	$('input[name="education"]').keypress(function() {
		if (this.value.length >= 75) {
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
</script>
@endsection
