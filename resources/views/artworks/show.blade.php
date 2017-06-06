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

<div id="imagePopup">
	<span class="glyphicon glyphicon-remove custom_glyphicon-remove"></span>
	<img src="/{{ $artwork->file }}" alt="" id="imagePopupImage">
</div>

<div class="col-md-8 col-md-offset-2 artworkPage">
<a href="/gallery" class="btn btn-primary">Galerij</a><br><br>
<div class="panel-default">
		
		<div class="artworkTitleBar panel-heading">
			<h2 class="artworkTitle">{{ $artwork->title }}</h2>
			@if (Auth::check())
        		<a href="/reservation/create/{{$artwork->id}}" id="btnAdd" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Maak reservering</a>
    		@endif
			@if(Auth::check() && Auth::user()->hasOnePrivelege(['Administrator']))
				<div class="artworkOptions">
					<a href="/artworks/{{ $artwork->slug }}/edit" title="Kunstwerk wijzigen">
						<i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
					</a>
					@if ($artwork->state === 0)
						<a href="/artworks/{{ $artwork->id }}/archive" onclick="return confirm('Weet u zeker dat u dit kunstwerk wilt archiveren?')" title="Archiveren">
							<i class="fa fa-archive fa-2x" aria-hidden="true"></i>
						</a>
					@else
						<a href="/artworks/{{ $artwork->id }}/archive" onclick="return confirm('Weet u zeker dat u dit kunstwerk uit het archief wil halen en weer in de galerij wil tonen?')" title="Uit het archief halen en terug zetten in de galerij">
							<i class="fa fa-archive fa-2x" aria-hidden="true"></i>
						</a>
						<a href="/artworks/{{ $artwork->id }}/destroy" onclick="return confirm('Als u verder gaat, wordt het kunstwerk definitief van de website verwijderd. Weet u dit zeker?')" title="Verwijderen">
							<i class="fa fa-trash fa-2x" aria-hidden="true"></i>
						</a>
					@endif
				</div>
			@endif
		</div>
		
		<div class="col-md-4" style="padding: 0; margin-top: 10px;">
			<img class="artworkImage" src="/{{ $artwork->file }}" alt="">
			<i>Klik op de afbeelding om te vergroten.</i>
		</div>
	
		@if (!empty($reservations[0]->from_date))
		<div>Begin datum reservering: {{ $reservations[0]->from_date }}.</div>
		<br>
		@else
		<p> Geen reservering op het moment.</p>
		@endif

		@if (!empty($reservations[0]->to_date))
		<div>Eind datum reservering: {{ $reservations[0]->to_date }}.</div>
		<br>

		@endif

		@if (!empty($reservations[0]->delivery_adress))
		<div>Locatie: {{ $reservations[0]->delivery_adress }}.</div>
		<br>
		@else
		<p> Geen locatie opgegeven</p>
		@endif
		<div class="col-md-8 artworkInfo" style="margin-top: 10px;">
			<div class="col-md-12 artworkDescription">{!! $artwork->description !!}</div>
			<div class="artworkInfoTable">
			@if (!empty($artist['name']))
				<div class="col-md-3"><b>Kunstenaar</b></div>
				<div class="col-md-9" style="height: 20px;">
					<a href="{{ $artist['profileLink'] }}">{!! $artist['name'] !!}</a>
				</div>
			@endif
			@if (!empty($artwork->technique))
				<div class="col-md-3"><b>Techniek</b></div>
				<div class="col-md-9" style="height: 20px;"><a href="/gallery/search?keyword=&kunstenaar=Alle+Kunstenaars&categorie=Alle+Categorieën&genre=Alle+Genres&materiaal=Alle+Materialen&techniek={!! $artwork->technique !!}&grootte=Alle+Grootte">{!! $artwork->technique !!}</a></div>
			@endif
			@if (!empty($artwork->material))
				<div class="col-md-3"><b>Materiaal</b></div>
				<div class="col-md-9" style="height: 20px;"><a href="/gallery/search?keyword=&kunstenaar=Alle+Kunstenaars&categorie=Alle+Categorieën&genre=Alle+Genres&materiaal={!! $artwork->material !!}&techniek=Alle+Technieken&grootte=Alle+Grootte">{!! $artwork->material !!}</a></div>
			@endif
			@if (!empty($artwork->category))
				<div class="col-md-3"><b>Categorie</b></div>
				<div class="col-md-9" style="height: 20px;"><a href="/gallery/search?keyword=&kunstenaar=Alle+Kunstenaars&categorie={!! $artwork->category !!}&genre=Alle+Genres&materiaal=Alle+Materialen&techniek=Alle+Technieken&grootte=Alle+Grootte">{!! $artwork->category !!}</a></div>
			@endif
			@if (!empty($artwork->genre))
				<div class="col-md-3"><b>Genre</b></div>
				<div class="col-md-9" style="height: 20px;"><a href="/gallery/search?keyword=&kunstenaar=Alle+Kunstenaars&categorie=Alle+Categorieën&genre={!! $artwork->genre !!}&materiaal=Alle+Materialen&techniek=Alle+Technieken&grootte=Alle+Grootte">{!! $artwork->genre !!}</a></div>
			@endif
			<!--
				<div class="col-md-3 col-sm-3 col-xs-3"><b>Formaat</b></div>
				<div class="col-md-9 col-sm-9 col-xs-9">{!! $artwork->size !!}</div>
			
				<div class="col-md-3 col-sm-3 col-xs-3"><b>Kleur</b></div>
				<div class="col-md-9 col-sm-9 col-xs-9">{!! $artwork->colour !!}</div>
			-->
			@if ($artwork->price != 0)
				<div class="col-md-3"><b>Prijs</b></div>
				<div class="col-md-9" style="height: 20px;">€{!! $artwork->price !!}</div>
			@endif
			@if (!empty($tagArray))
				<div class="tagsDiv">
					<div class="col-md-3"><b>Tags</b></div>
					<div class="col-md-9">
				<?php $i = 1; ?>
					@foreach($tagArray as $tag)
						<span class="glyphicon glyphicon-tag"></span><a href="/gallery/search?keyword={{ $tag }}&kunstenaar=Alle+Kunstenaars&categorie=Alle+Categorieën&genre=Alle+Genres&materiaal=Alle+Materialen&techniek=Alle+Technieken&grootte=Alle+Grootte"> {{ $tag }}</a>@if ($i < count($tagArray)){{ ',' }}
						@endif
				<?php $i++ ?>
					@endforeach
					</div>
				</div>
			@endif
			</div>
		</div>
		{{--
		<div class="col-md-12" style="padding: 0;">
			<div class="col-md-6" style="padding: 0;">
				<h1 style ="padding:20,20,20,0">Reserveringen voor {{$artwork->title}}</h1>
				<div id="calendar">

				</div>
				<br><br>
				<div class="fb-like" data-href="http://www.artotheekdavinci.nl/artworks/{{ $artwork->slug }}" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
			</div>
		</div>--}}
	</div>
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
	
	$('.artworkImage').click(function() {
		$('#imagePopup').toggle();
	});
	
	window.addEventListener('mouseup', function(event){
		var viewer = document.getElementById("imagePopupImage");
		if(event.target != viewer && event.target.parentNode != viewer) {
			document.getElementById('imagePopup').style.display = "none";
		}
	});

</script>

@stop
