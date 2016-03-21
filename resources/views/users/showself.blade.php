@extends('app')
@section('content')

<div class="panel panel-default">
<div class="panel-heading">
	<h1>Mijn Profiel</h1><a class="btn btn-warning" href="{{$user->slug}}/edit">Wijzig</a>
</div>
	<div class="panel-body">
		<table class=table>
			<tr>
				<td><b>Naam</b></td>
				<td colspan="3">{{$user->name}}</td>
			</tr>
			<tr>
				<td><b>E-mail</b></td>
				<td colspan="3">{{$user->email}}</td>
			</tr>
			<tr>
				<td><b>Lid sinds</b></td>
				<td colspan="3">{{$user->created_at}}</td>
			</tr>
			<tr>
				<td><b>Telefoon nummer</b></td>
				<td colspan="3">{{$user->telephone}}</td>
			</tr>
			<tr>
				<td><b>Opleiding</b></td>
				<td>{{$user->education}}</td>
				<td><b>Leerjaar</b></td>
				<td>{{$user->school_year}}</td>
			</tr>
			<tr>
				<td><b>Overzicht werk</b></td>
				<td colspan="3">{{$user->work_summary}}</td>
			</tr>
			<tr>
				<td><b>Kostenplaatje</b></td>
				<td colspan="3">{{$user->price}}</td>
			</tr>
			<tr>
				<td><b>Bezorg adres</b></td>
				<td>{{$user->delivery_address}}</td>
				<td><b>Postcode</b></td>
				<td>{{$user->zip}}</td>
			</tr>
			<tr>
				<td><b>Sector/Afdeling</b></td>
				<td colspan="3">{{$user->sector}}</td>
			</tr>	
		</table>
	</div>
	
</div>

@stop