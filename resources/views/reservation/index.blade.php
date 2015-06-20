@extends('app')
@section('content')

<div class="panel panel-default">
  <div class="panel-heading">Reserveringen</div>


  <table class="table">
    <tr>
    	<th>Kunstwerk</th>
    	<th>Kunstenaar</th>
    	<th>Van</th>
    	<th>Tot</th>
    </tr>
    @foreach($reservations as $reservation)
    <tr>
    	<td><a href="artworks/{{$reservation->artworkSlug}}">{{ $reservation->title }}</a></td>
    	<td><a href="users/{{$reservation->userSlug}}">{{ $reservation->name }}</a></td>
    	<td>{{ $reservation->from_date }}</td>
    	<td>{{ $reservation->to_date }}</td>
    </tr>
    @endforeach
  </table>
</div>






@stop