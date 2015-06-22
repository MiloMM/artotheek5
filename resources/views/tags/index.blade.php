@extends('app')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Alle tags</h2>
				</div>
				<div class="panel-body">
					@foreach($allTags as $tag)
						<span class="glyphicon glyphicon-tag"></span><a href="/tags/{{$tag->name}}">{{ $tag->name }}</a><hr>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>



@stop