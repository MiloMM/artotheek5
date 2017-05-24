@extends('app')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Evenementen</div>
				<div class="panel-body">
					<a href="{{ action('EventController@create') }}" style="margin: 10px;" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Nieuw Evenement</a>
					@if($events->count() > 1)
						@foreach ($events->reverse() as $event)
							<div class="panel panel-default">
								<div class="panel-heading">{{ $event->title }}</div>
								<div class="panel-body">{!! $event->content !!}</div>
								<a href="/events/{{ $event->slug }}" style="margin: 10px;" class="btn btn-success">Volledig Evenement</a>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@stop