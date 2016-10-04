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

<div class="col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading" style="height: 50px;">
			<div style="float: left">
				<h2 style="margin-top: -2px;">{{ $artwork->title }}</h2>
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
		
		<div class="">
			
		</div>
		<center><img src="/{{ $artwork->file }}" alt="" style="width: 100%; max-width: 800px; max-height: 700px;"></center>	
		<div class="fb-like" data-href="http://www.artotheekdavinci.nl/artworks/{{ $artwork->slug }}" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
		<div class="panel-body">{!! $artwork->description !!}</div>
		<div class="panel-heading">
			<p>Kunstenaar: {!! $artwork->artist !!}</p>
			<p>Techniek: {!! $artwork->technique !!}</p>
			<p>Categorie: {!! $artwork->category !!}</p>
			<p>Formaat: {!! $artwork->size !!}</p>
			<p>Prijs: €{!! $artwork->price !!}</p>
		</div>
		
		<p class="tag-paragraph"> 
			@foreach($tagArray as $tag)
				<span class="glyphicon glyphicon-tag"></span><a href="/tags/{{$tag}}">{{ $tag }}</a>
			@endforeach
		</p>
	</div>
	<h1 style ="padding:20,20,20,0">Reserveringen voor {{$artwork->title}}</h1>
	<div id="calendar">
		
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
</script>

@stop