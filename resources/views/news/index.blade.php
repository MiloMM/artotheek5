@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Nieuws Artikelen</div>
				<div class="panel-body">
					@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
						<a href="{{ action('NewsController@create') }}" style="margin: 10px;" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nieuw Artikel</a>
					@endif
					@foreach ($articles->reverse() as $article)
						<div class="panel panel-default">
							<div class="panel-heading">{{ $article->title }}</div>
							<div class="panel-body">{!! $article->content !!}</div>
							<a href="/news/{{ $article->slug }}" style="margin: 10px;" class="btn btn-success">Volledig Artikel</a>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@stop