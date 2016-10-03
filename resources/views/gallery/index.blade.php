@extends('app')
@section('content')
<div class="container-fluid" ng-controller="galleryController">
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator']))
		<a href="{{ action('ArtworkController@create') }}" id="btnAdd" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Voeg toe</a>
		@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
			<a href="{{ action('ArtworkController@showArchived') }}" id="btnShowArchived" class="btn btn-primary">Bekijk Gearchiveerd</a>
		@endif
		<hr>
	@endif
	<!--<div class="col-md-4 col-xs-6 thumb artwork-container" ng-repeat="artwork in artworks">
		<span class="artwork-container-helper"></span>
		<a href="/artworks/@{{ artwork.slug }}">
			<img src="@{{ artwork.file }}" class="img-responsive artwork-image">
		</a>
	</div>-->
	<h1>Galerij</h1>
	<div class="flex-container" ng-controller="galleryController">
		<div class="img-box" ng-repeat="artwork in artworks">
			<a href="/artworks/@{{ artwork.slug }}">
				<img src="@{{ artwork.file }}" class="img-box-image">
			</a>
		</div>
	</div>
</div>
<script>
	$(function () {
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
	});
</script>
@endsection