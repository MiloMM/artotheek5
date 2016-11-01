@extends('app')
@section('content')
<div class="panel panel-default">
<div class="panel-heading" style="position: relative;">
	<h1>Kunstenaar Profiel</h1>
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
		<a href="/destroy/{{$user->id}}" class="profileDeleteButton">Verwijder alles van deze kunstenaar</a>
	@endif
</div>
	<div class="panel-body">
		<table class=table>
			<tr>
				<td><b>Naam</b></td>
				<td colspan="3">{{$user->name}}</td>
			</tr>
			@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
			<tr>
				<td><b>E-mail</b></td>
				<td colspan="3">{{$user->email}}</td>
			</tr>
			@endif
			<tr>
				<td><b>Lid sinds</b></td>
				<td colspan="3">{{$user->created_at}}</td>
			</tr>
			@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
			<tr>
				<td><b>Telefoon nummer</b></td>
				<td colspan="3">{{$user->telephone}}</td>
			</tr>
			@endif
			<tr>
				<td><b>Opleiding / Sector</b></td>
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
		</table>
	</div>
</div>
@stop
