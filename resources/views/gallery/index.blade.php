@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default" ng-controller="galleryController">
				<div class="panel-heading">Gallerij</div>
				<div class="panel-body">
					@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
						<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Voeg toe</a>
						<hr>
					@endif
				    <input type="text" ng-model="artworkQuery" placeholder="Zoek..." class="form-control">
				    <hr>

					<div class="row">
					   	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
				    		<h1>Gepubliceerd</h1>
				    		<hr>
						@endif
						<!-- <div class="col-lg-3 col-md-4 col-xs-6 thumb artwork-container"> -->
                   		 <div class="col-md-4 col-xs-6 thumb artwork-container" ng-repeat="artwork in artworks | filter:artworkQuery">                   		 	
                   		 	<span class="artwork-container-helper"></span>
						    <a href="/artworks/@{{ artwork.slug }}">
						    	<img src="@{{ artwork.file }}" class="img-responsive artwork-image">
						    </a>
						    <p class="artwork-label">@{{ artwork.title }}</p>
						 </div>
					</div>
					
					<div class="panel-body"></div>
						@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
							<h1>Gearchiveerd</h1>
							<hr>
							<div class="col-md-4 col-xs-6 thumb artwork-container" ng-repeat="archivedArtwork in archivedArtworks | filter:archivedArtworkQuery">      			
	                   		 	<span class="artwork-container-helper"></span>
							    <a href="/artworks/@{{ archivedArtwork.slug }}">
							    	<img src="@{{ archivedArtwork.file }}" class="img-responsive artwork-image">
							    </a>
							    <p class="artwork-label">@{{ archivedArtwork.title }}</p>
							</div>
						@endif
					</div>
				</div>
			</div>
	</div>
</div>
<script>
	app.controller('galleryController', function ($http, $scope) {
		var request = $http.get('{{ url("/json/artworks") }}');
		request.then(function (response) {
			$scope.artworks = response.data;
		});
		@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
			request = $http.get('{{ url("/json/archivedArtworks") }}');
			request.then(function (response) {
				$scope.archivedArtworks = response.data;
			});
		@endif
	});
</script>
@endsection