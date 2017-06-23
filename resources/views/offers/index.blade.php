<link rel="stylesheet" href="<?php echo asset('css/offers.css')?>" type="text/css"> 
@extends('app')
@section('content')

<img src="/{{ $artworks->file }}" alt="" id="imagePopupImage">

<div>Voorgestelde prijs door kunstenaar: {!! $artworks->price !!}</div>
<div>Geboden prijzen:</div>

@foreach ($offers as $offer)

{{ $offer->name }}:
{{ $offer->offers }}

<br>
	@endforeach
	<br><br>
<form action="offers/createOffers">
  Bieden:<br>
  <input type="number" name="offer" value="" step="any" min="0">
   <input type="hidden" name="name" value="{!! $userOffer !!}">
   <input type="hidden" name="artworkId" value="{!! $artworks->id !!}">	
  <input type="submit" value="Submit">
</form> 
@stop