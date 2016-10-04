@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-header">
		<div style="padding-left: 15px;"><h1 id='indexPageTitle'>Da Vinci Artotheek</h1></div>
	</div>
	<div class="panel-body">
	<p id="indexPageIntroduction">
		Curabitur eleifend condimentum tristique. Aenean feugiat orci <br>non nunc feugiat luctus. Suspendisse non pretium quam. Aliquam imperdiet<br> malesuada congue. Duis quis libero rhoncus, varius ligula sit amet, efficitur nunc. Mauris <br>et purus et mi dignissim elementum eget id purus. Pellentesque in neque rutrum, mollis neque quis, varius<br> ex. Quisque eleifend, lorem id rutrum placerat, magna dolor rhoncus lectus, vel tempus tortor felis id arcu. Curabitur orci nibh.<br><br>
	</p>
	<div class="panel-header">
		<p style="color:black"><h4>Recent toegevoegd:</h4></p>
	</div>
		<div class="flex-container" ng-controller="galleryController">
			<div class="img-box" ng-repeat="artwork in artworks|limitTo:8">
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