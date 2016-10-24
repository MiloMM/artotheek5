@extends('app')
@section('content')
<h1>Pas filters aan</h1>
<ul class="nav nav-tabs" role="tablist">
	@foreach($filters as $filter)
    	<li role="presentation" class=""><a href="{{route('filterIndex', $filter->id)}}" class="FilterTabLink" role="tab">{{$filter->naam}}</a></li>
    @endforeach
</ul>
<div class="row">
	<div class="col-md-6">
		<h3>Voeg een {{$filters[$id-1]->naam}} toe</h3>
		@if(session('succesMsg'))
			<div class="alert alert-success"> {!!session('succesMsg')!!} </div>
		@endif
		@if(session('errorMsg'))
			<div class="alert alert-success errorMsg"> {!!session('errorMsg')!!} </div>
		@endif
		
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="">
					{!! Form::open(array('url' => 'filters', 'required')) !!}
						{!! Form::token() !!}
						{!! Form::hidden('filter_id', $id) !!}
						{!! Form::label('naam', 'Naam') !!}
						{!! Form::text('naam', null, ['class' => 'form-control custom-spacer', 'placeholder' => $filters[$id-1]->naam]) !!} <br/>
						{!! Form::submit('Voeg toe', ['class' => 'btn btn-primary']) !!}

					{!! Form::close() !!}
				</div>
			</div>
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
					<a class="fa fa-pencil-square-o filter-options" href="/filters/{{$filter_optie->filter_id}}/{{$filter_optie->id}}/edit" onclick="return confirm('Weet u zeker dat u \'{{$filter_optie->naam}}\' uit het filter wilt verwijderen?')"></a>
					<a class="fa fa-trash filter-options" href="/filters/{{$filter_optie->filter_id}}/{{$filter_optie->id}}/delete" onclick="return confirm('Weet u zeker dat u \'{{$filter_optie->naam}}\' uit het filter wilt verwijderen?')"></a>
				</td>
			</tr>
		@endforeach
		</table>
	</div>
</div>
@stop