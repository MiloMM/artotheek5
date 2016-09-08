@extends('app')
@section('content')
<div class="panel panel-default">
	<div class="panel-header">
		<div style="text-align: center;"><h1>Da Vinci Artotheek</h1></div>
	</div>
	<div class="panel-body">
		<div style="text-align: center;"><p>Hier komt de super mooie homepage van de artotheek.</p></div>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus magni officia sequi, eos voluptatem assumenda quod deserunt tempora nulla aperiam impedit eveniet nisi aliquid dolore cum modi molestias ipsa. Dignissimos.
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero adipisci, provident error, est explicabo architecto eligendi reiciendis. Expedita earum, ex iure. Voluptatem, rem minima cupiditate provident adipisci, perspiciatis debitis culpa.
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia quod reprehenderit, pariatur alias, rem illo modi earum distinctio voluptatibus est, corrupti delectus. Adipisci similique eveniet distinctio tenetur voluptatem iusto dolorum.
		</p>
	<div class="panel-header">
		<div style="text-align: center;"><a href="/gallery" class="custom-gallery-link"><h2>Gallerij</h2></a></div>
	</div>
		<div class="container-fluid" ng-controller="galleryController">
			<div class="col-md-2 col-xs-6 thumb artwork-container" ng-repeat="artwork in artworks">
			 	<span class="artwork-container-helper"></span>
			    <a href="/artworks/@{{ artwork.slug }}">
			    	<img src="@{{ artwork.file }}" class="img-responsive artwork-image">
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