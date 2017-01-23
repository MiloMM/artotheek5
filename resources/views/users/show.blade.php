@extends('app')
@section('content')
<div class="panel panel-default">
<div class="panel-heading">
	<h1>Kunstenaar Profiel</h1>
	@if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
		<a href="/users/destroy/{{ $user->id }}" class="fa fa-times fa-2x profileDeleteButton" title="Account verwijderen" onclick="return confirm('Weet u zeker dat u dit profiel en account wilt verwijderen? De kunstenaar die aan dit profiel is gekoppeld blijft bestaan.')"></a>
	@endif
</div>
	<div class="container profileDetails" style="padding: 0;">
		<div class="col-md-10">
			<div class="col-md-6">
				<div class="col-md-3"><b>Naam</b></div>
				<div class="col-md-9">{{$user->name}}</div>
			</div>
			
			<div class="col-md-6">
				<div class="col-md-3"><b>Lid sinds</b></div>
				<div class="col-md-9">{{$user->created_at}}</div>
			</div>
			@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
			<div class="col-md-6">
				<div class="col-md-3"><b>E-mail</b></div>
				<div class="col-md-9">{{$user->email}}</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-3"><b>Telefoon nummer</b></div>
				<div class="col-md-9">{{$user->telephone}}</div>
			</div>
			@endif
			<div class="col-md-6">
				<div class="col-md-3"><b>Opleiding / Sector</b></div>
				<div class="col-md-9">{{$user->education}}</div>
			</div>	
			
			<div class="col-md-6">
				<div class="col-md-3"><b>Leerjaar</b></div>
				<div class="col-md-9">{{$user->school_year}}</div>
			</div>
			{{--<div class="col-md-6">
				<div class="col-md-3"><b>Overzicht werk</b></div>
				<div class="col-md-9">{{$user->work_summary}}</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-3"><b>Kostenplaatje</b></div>
				<div class="col-md-9">{{$user->price}}</div>
			</div>--}}
			@if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
				<div class="col-md-6">
					<div class="col-md-3"><b>Adres</b></div>
					<div class="col-md-9">{{$user->delivery_address}}</div>
				</div>
				<div class="col-md-6">
					<div class="col-md-3"><b>Postcode</b></div>
					<div class="col-md-9">{{$user->zip}}</div>
				</div>
			@endif
			@if ($user->biography != '')
				<div class="col-md-12 biography">{!! $user->biography !!}</div>
			@endif
		</div>
		<div class="col-md-2">
			@if ($user->profile_picture != '')
				<img src="{{$user->profile_picture}}" class="profile_pic">
			@else
				<i class="no_profile_pic">Geen profielafbeelding</i>
			@endif
		</div>
	</div>
	<h4>Kunstwerken</h4>
	@if (count($artworks) > 0)
		@foreach ($artworks as $artwork)
		<div class="img-box-search">
			<a href="/artworks/{{ $artwork->slug }}">
				<img class="img-box-image" src="/{{$artwork->file}}" />
				<h3>{{$artwork->title}}</h3>
			</a>
		</div>
		@endforeach
	@else
		<i>Geen</i>
	@endif
</div>
		
@stop
