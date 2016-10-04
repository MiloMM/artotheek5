@extends('app')
@section('content')
<div class="container-fluid" ng-controller="galleryController">
	<a href="{{ action('PagesController@gallery') }}" id="btnShowPublished" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Naar de galerij</a>
	<h1>Het archief</h1>
	
	<hr>
	
	 <div class="flex-container" ng-controller="galleryController">
		<div class="img-box" ng-repeat="artwork in artworks">
			<a href="/artworks/@{{ artwork.slug }}">
				<img src="/@{{ artwork.file }}" class="img-box-image">
			</a>
		</div>
	</div>
</div>
<script>
	$(function () {
		app.controller('galleryController', function ($http,  $scope) {
		var request = $http.get('{{ url("/json/archivedArtworks") }}');
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