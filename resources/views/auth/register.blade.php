@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Naam</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Adres</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
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
								<input type="number" class="form-control" name="school_year" value="{{ old('school_year') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Adres</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="delivery_address" value="{{ old('delivery_address') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Postcode</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="zip" value="{{ old('zip') }}">
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
