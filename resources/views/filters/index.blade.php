@extends('app')
@section('content')
<div class="col-md-12">
	<h1>Pas filters aan</h1>
</div>

<ul class="nav nav-tabs" role="tablist">
	@foreach($filters as $filter)
    	<li role="presentation" class=""><a href="{{route('filterIndex', $filter->id)}}" class="FilterTabLink" role="tab">{{$filter->naam}}</a></li>
    @endforeach
</ul>

	<div class="col-md-6">
		<h3>Voeg een {{$filters[$id-1]->naam}} toe</h3>
		@if(session('succesMsg'))
			<div class="alert alert-success"> {!!session('succesMsg')!!} </div>
		@endif
		@if(session('errorMsg'))
			<div class="alert alert-success errorMsg"> {!!session('errorMsg')!!} </div>
		@endif


				<div class="">
					{!! Form::open(array('url' => 'filters', 'required')) !!}
						{!! Form::token() !!}
						{!! Form::hidden('filter_id', $id) !!}
						{!! Form::label('naam', 'Naam') !!}
						{!! Form::text('naam', null, ['class' => 'form-control custom-spacer']) !!} <br/>
						{!! Form::submit('Voeg toe', ['class' => 'btn btn-primary']) !!}

					{!! Form::close() !!}
				</div>

	</div>
	<div class="col-md-6">
		<h3>Overzicht</h3>
		<table class="table table-striped">
			<tr>
				<th>Naam</th>
				<th>Opties</th>
			</tr>
		@foreach($filter_opties as $filter_optie)
			<tr>
				<td width="75%">{{$filter_optie->naam}}</td>
				<td style="width:25%; text-align:right;">
					<a class="fa fa-pencil-square-o filter-options" href="/filters/{{$filter_optie->filter_id}}/{{$filter_optie->id}}/edit"title="Wijzigen"></a>
					<a class="fa fa-trash filter-options" href="/filters/{{$filter_optie->filter_id}}/{{$filter_optie->id}}/delete" onclick="return confirm('Weet u zeker dat u \'{{$filter_optie->naam}}\' uit het filter wilt verwijderen?')" title="Verwijderen"></a>
				</td>
			</tr>
		@endforeach
		</table>
	</div>
@stop
