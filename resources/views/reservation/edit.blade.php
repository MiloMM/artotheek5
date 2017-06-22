@extends('app')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Wijzig de reservatie.</b></div>
				<div class="panel-body">
					{!! Form::open(['class' => 'form-horizontal', 'id' => 'form', 'method' => 'put', 'action' => ['ReservationController@update', $reservation->id]]) !!}
        			<div class="form-group"> 
         				 {!! Form::label('Datum van:', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!} 
         				 {!! Form::input('text', 'from_date', $reservation->from_date, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        			</div>
             		<div class="form-group"> 
         				{!! Form::label('Datum tot:', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!} 
         				{!! Form::input('text', 'to_date', $reservation->to_date, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        			</div>
        			<div class="form-group"> 
         				 {!! Form::label('Bezorg adres', null, ['class' => 'col-md-2 control-label', 'style'=>'text-align:center']) !!} 
         				 {!! Form::input('text', 'delivery_adress', $reservation->delivery_adress, ['class' => 'col-md-10 form-control', 'style' => 'width:175px;', 'required' => 'required']) !!} 
        			</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							{!! Form::submit('Aanpassen', ['class' => 'btn btn-success form-control', 'id' => 'btn-send']) !!}
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>

@stop