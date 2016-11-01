@extends('app')
@section('content')

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="col-md-8 col-md-offset-2 artworkPage">
		<div class="artworkTitleBar">
			<div style="float: left">
				<h2>{{ $artwork->title }}</h2>
			</div>
			@if(Auth::check())
				<div style="float: right">
					<a href="/artworks/{{ $artwork->slug }}/edit" title="Wijzigen">
						<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
					</a>
					<a href="/reservation/create/{{ $artwork->id }}" title="Reserveren">
						<i class="fa fa-book fa-2x" aria-hidden="true"></i>
					</a>
					@if ($artwork->state === 0)
						<a href="/artworks/{{ $artwork->id }}/archive" onclick="return confirm('Weet u zeker dat u dit kunstwerk wilt archiveren?')" title="Archiveren">
							<i class="fa fa-archive fa-2x" aria-hidden="true"></i>
						</a>
					@else
						<a href="/artworks/{{ $artwork->id }}/archive" onclick="return confirm('Weet u zeker dat u dit kunstwerk wilt uit het archief wil halen en weer in de galerij wil tonen?')" title="Uit het archief halen en terug zetten in de galerij">
							<i class="fa fa-archive fa-2x" aria-hidden="true"></i>
						</a>
						<a href="/artworks/{{ $artwork->id }}/destroy" onclick="return confirm('Als u verder gaat, wordt het kunstwerk definitief van de website verwijderd. Weet u dit zeker?')" title="Verwijderen">
							<i class="fa fa-trash fa-2x" aria-hidden="true"></i>
						</a>
					@endif
				</div>
			@endif
		</div>
		<center class="centerImage"><img class="showArtworkImage" src="/{{ $artwork->file }}" alt=""></center>
		
		<div class="artworkInfo">
			<div class="col-md-12">{!! $artwork->description !!}</div>
			
			<div class="col-md-2">Kunstenaar</div>
			<div class="col-md-1">:</div>
			<div class="col-md-9">{!! $artwork->artist !!}</div>
			
			<div class="col-md-2">Techniek</div>
			<div class="col-md-1">:</div>
			<div class="col-md-9">{!! $artwork->technique !!}</div>
			
			<div class="col-md-2">Categorie</div>
			<div class="col-md-1">:</div>
			<div class="col-md-9">{!! $artwork->category !!}</div>
			
			<div class="col-md-2">Formaat</div>
			<div class="col-md-1">:</div>
			<div class="col-md-9">{!! $artwork->size !!}</div>
			
			<div class="col-md-2">Prijs</div>
			<div class="col-md-1">:</div>
			<div class="col-md-9">€{!! $artwork->price !!}</div>
			
			<div class="col-md-12 tagsDiv">
			<?php $i = 1; ?>
				@foreach($tagArray as $tag)
					<span class="glyphicon glyphicon-tag"></span><a href="/tags/{{$tag}}"> {{ $tag }}</a>@if ($i < count($tagArray)){{ ',' }}
					@endif
			<?php $i++ ?>
				@endforeach
			</div>
		</div>
	<br><br>
	<h1 style ="padding:20,20,20,0">Reserveringen voor {{$artwork->title}}</h1>
	<div id="calendar">
		
	</div>
	<br><br>
	<div class="fb-like" data-href="http://www.artotheekdavinci.nl/artworks/{{ $artwork->slug }}" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
</div>
<script>
	$(function () {
		reservations =  <?php echo json_encode($reservations); ?>;

		function createEvents(){
		    var events = [];
		    for (var r in reservations){
		        var nextevent = {
		            title  : reservations[r].title,
		            start  : reservations[r].from_date,
		            end    : reservations[r].to_date,
		            url	   : '/artworks/' + reservations[r].artworkSlug
		        }
		        events[events.length] = nextevent;
		    }
		    return events;

		}

		$('#calendar').fullCalendar({
		    events: createEvents()
		});
	});
</script>

@stop