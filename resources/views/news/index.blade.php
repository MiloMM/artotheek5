@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nieuws Artikelen</div>
				<div class="panel-body" ng-controller="newsController">
					@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
						<a href="{{ action('NewsController@create') }}" style="margin: 10px;" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nieuw Artikel</a>
					@endif
					<input type="text" class="form-control" placeholder="Zoek..." ng-model="newsQuery">
					<hr>
					<div class="panel panel-default" ng-repeat="article in articles | filter:newsQuery">
						<div class="panel-heading">@{{ article.title }}</div>
						<div class="panel-body" ng-bind-html="article.content"></div>
						<a href="/news/@{{ article.slug }}" style="margin: 10px;" class="btn btn-success">Volledig Artikel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	app.controller('newsController', function ($scope, $http) {
        $scope.articles = [{}];
        var request = $http.get('{{ url("/json/news") }}');
        request.then(function (response) {
            $scope.articles = response.data;
        });
        
        $scope.events = [{}];
        
    });
</script>
@stop