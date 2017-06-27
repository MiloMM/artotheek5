@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nieuws Artikelen</div>
				<div class="panel-body" ng-controller="newsController">
				<input type="text" class="form-control" placeholder="Zoek..." ng-model="newsQuery">
					@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
						<a href="{{ action('NewsController@create') }}" style="margin: 10px;" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nieuw Artikel</a>
						<hr>
					@endif
					<div class="panel panel-default" {{--ng-repeat="article in articles | filter:newsQuery"--}}>
					@foreach($articles as $article)
						<div class="panel-heading" style="font-size: 24px;">{{$article->title}} </div>
						<div class="panel-body" ng-bind-html="article.content">{{$article->content}}</div>
						<a href="/news/article/{{$article->slug}}" style="margin: 10px;" class="btn btn-success">Volledig Artikel</a>
					@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	app.controller('newsController', function ($scope, $http, $sce) {
        var request = $http.get('{{ url("/json/news") }}');
        request.then(function (response) {
        	var untrustedData = response.data;
        	$(untrustedData).each(function (k, v) {
        		console.log($sce.trustAsHtml(untrustedData[k].content));
        		untrustedData[k].content = $sce.trustAsHtml(untrustedData[k].content);
        	});
            $scope.articles = untrustedData;
        });
    });
</script>
@stop