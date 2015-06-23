@extends('app')
@section('content')


<div class="panel panel-default">
  <div class="panel-heading">Reserveringen</div>

  <table class="table">
    <tr>
        <th>Reservering nr. <span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
    	<th>Kunstwerk</th>
    	<th>Kunstenaar</th>
    	<th>Van</th>
    	<th>Tot</th>
    </tr>
    @foreach($reservations as $reservation)
    <tr>
        <?php
            $date = new DateTime($reservation->from_date);
            $date2 = new DateTime($reservation->to_date);
            $reservation->from_date = date_format($date, 'd-m-Y');
            $reservation->to_date = date_format($date2, 'd-m-Y');
         ?>
        <td>{{ $reservation->reservationId }}</td>
    	<td><a href="artworks/{{$reservation->artworkSlug}}">{{ $reservation->title }}</a></td>
    	<td><a href="users/{{$reservation->userSlug}}">{{ $reservation->name }}</a></td>
    	<td>{{ $reservation->from_date }}</td>
    	<td>{{ $reservation->to_date }}</td>
    </tr>
    @endforeach    
</div>
@stop