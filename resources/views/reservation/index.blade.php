@extends('app')
@section('content')

    <div class="row">
    <div class="col-md-12">
<div class="panel panel-default">
  <div class="panel-heading">Reserveringen</div>


        
  <table class="table">

  <thead>

    <tr>
        <th width="16%">Reservering nr. <span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
    	<th width="16%">Kunstwerk <span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
    	<th width="16%">Kunstenaar <span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
    	<th width="16%">Van <span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
    	<th width="16%">Tot <span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
        <th width="16%">Aflever Adres<span class="glyphicon glyphicon-chevron-up"></span><span class="glyphicon glyphicon-chevron-down"></span></th>
        <th width="4%">Opties</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reservations as $reservation)
    <tr>
        <?php
            $date = new DateTime($reservation->from_date);
            $date = date_format($date, 'd-m-Y');   //conver dats to readable format
            $date2 = new DateTime($reservation->to_date);
            $date2 = date_format($date2, 'd-m-Y');
         ?>
        <td>{{ $reservation->reservationId }}</td>
    	<td><a href="artworks/{{$reservation->artworkSlug}}">{{ $reservation->title }}</a></td>
    	<td><a href="users/{{$reservation->userSlug}}">{{ $reservation->name }}</a></td>
    	<td>{{ $date }}</td>
    	<td>{{ $date2 }}</td>
        <td>{{ $reservation->delivery_adress }}</td>
		<td><a href="reservation/show/{{ $reservation->reservationId }}" title="Inzien"><span class="glyphicon glyphicon-eye-open"></span></a>
            <a href="reservation/destroy/{{ $reservation->reservationId }}" title="Verwijder"><span class="glyphicon glyphicon-trash"></span></a>
        </td>


    </tr>
    @endforeach    
    </tbody>
    </table>
    </div>


</div>
    <div class="col-md-6">
        <div id="calendar"></div>
    </div>
</div>

<script>
$(document).ready(function() 
    { 
        $(".table").tablesorter(); 
    } 
);

reservations =  <?php echo json_encode($reservations); ?>;
console.log(reservations);

function createEvents(){
    var events = [];
    for (var r in reservations){
        var nextevent = {
            title  : reservations[r].title,
            start  : reservations[r].from_date,
            end    : reservations[r].to_date,
            url    : '/artworks/' + reservations[r].artworkSlug
        }
        events[events.length] = nextevent;
    }
    return events;

}


/*$('#calendar').fullCalendar({
    events: createEvents()
});*/
</script>
@stop





