@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-header">
		<div style="padding-left: 15px;"><h1>Da Vinci Artotheek</h1></div>
	</div>
	<div class="panel-body">
		<!--<p>
			Welkom bij de Da Vinci Artotheek! Op deze website zijn verschillende kunstwerken te vinden die gemaakt zijn door de leerlingen van de Da Vinci Art & Design opleiding.
		</p>
		<br><br>-->
		Curabitur eleifend condimentum tristique. Aenean feugiat orci <br>non nunc feugiat luctus. Suspendisse non pretium quam. Aliquam imperdiet<br> malesuada congue. Duis quis libero rhoncus, varius ligula sit amet, efficitur nunc. Mauris <br>et purus et mi dignissim elementum eget id purus. Pellentesque in neque rutrum, mollis neque quis, varius<br> ex. Quisque eleifend, lorem id rutrum placerat, magna dolor rhoncus lectus, vel tempus tortor felis id arcu. Curabitur orci nibh<br>.
	<div class="panel-header">
		<a href="/gallery" class="custom-gallery-link" style="color:black"><h4>Recent toegevoegd:</h4></a>
	</div>
		<!--<div class="container-fluid" ng-controller="galleryController">
			<div class="col-md-2 col-xs-6 thumb artwork-container" ng-repeat="artwork in artworks">
			 	<span class="artwork-container-helper"></span>
			    <a href="/artworks/@{{ artwork.slug }}">
			    	<img src="@{{ artwork.file }}" class="img-responsive artwork-image">
			    </a>
			</div>
		</div>-->
		<div class="" ng-controller="galleryController">
			<div class="img-box" ng-repeat="artwork in artworks">
			 	<span class=""></span>
			    <a href="/artworks/@{{ artwork.slug }}">
			    	<img src="@{{ artwork.file }}" class="img-box-image">
			    </a>
			</div>
		</div>
		<script>
			$(function () {
				app.controller('galleryController', function ($http, $scope) {
					var request = $http.get('{{ url("/json/artworks") }}');
					request.then(function (response) {
						$scope.artworks = response.data;
					});
				});
			});
		</script>
	</div>
</div>
@stop