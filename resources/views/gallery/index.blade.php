@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Gallerij</div>
					<div class="panel-body">
						@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
							<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Voeg toe</a>
						@endif
					</div>
				<div class="panel-body">
					@if (Session::get('message') != null)
						<div class="alert alert-success">
							<p>{{ Session::get('message') }}</p>
						</div>
					@endif
					<div class="panel">
					    <input type="text" ng-model="eventQuery" placeholder="Zoek..." class="form-control">
					</div>
					<div class="row">
	                    @foreach ($artworks as $artwork)
	                   		 <div class="col-lg-3 col-md-4 col-xs-6 thumb artwork-container">
	                   		 	<span class="artwork-container-helper"></span>
							    <img src="{{ $artwork->file }}" class="img-responsive artwork-image">
							    <p class="artwork-label">{{ $artwork->title }}</p>
							</div>
						@endforeach
					</div>
				</div>
			</div>
	</div>
</div>
@endsection