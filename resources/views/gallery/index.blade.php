@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Gallerij</div>
					<div class="panel-body">
						<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Voeg toe</a>
					</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Oeps!</strong> Er waren problemen met jou ingevoerde gegevens.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					@if (Session::get('message') != null)
						<div class="alert alert-success">
							<p>{{ Session::get('message') }}</p>
						</div>
					@endif
					<div class="panel">
					    <input type="text" ng-model="eventQuery" placeholder="Zoek..." class="form-control">
					</div>
					<?php echo($artworks) ?>
					 <?php $count = 1; ?>
                    @foreach ($artworks as $artwork)
					<?php $count++; ?>
                    <div class="artwork-img col-md-4">
						    <img src="images/artworks/<?=$count?>.jpeg" class="img-responsive">
						    <p>{{ $artwork->title }}</p>
						</div>
					@endforeach
				</div>
			</div>
	</div>
</div>
@endsection