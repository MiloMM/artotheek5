<div id="custom_searchmenu" class="custom_searchmenu">
	<span id="searchtoggle_two" class="glyphicon glyphicon-remove custom_glyphicon-remove"></span>
	<img class="site_logo_menu" src="{{ asset('images/Galleria_logo_small.png') }}">
	{!! Form::open(array('url' => 'gallery/search', 'method' => 'get', 'required')) !!}
		{!! Form::token() !!}

		{!! Form::label('zoeken', 'Zoeken naar kunstwerken', ['class' => 'zoek_label']) !!}

		{!! Form::text('keyword', null, ['class' => 'form-control', 'placeholder' => 'Trefwoord']) !!}
		<br><br>
		{!! Form::submit('Zoeken', ['class' => 'btn btn-default search_submit']) !!};

		<p class="expandtext" id="expandtext">Filters (optioneel)</p>
		<div class="filter-box" id="filterbox">
			<div class="col-md-5">
				{!! Form::label('kunstenaar', 'Kunstenaar', ['class' => 'custom-label']) !!}
				<select class="select2-select form-control" name="kunstenaar">
				<option value="Alle Kunstenaars">Alle kunstenaars</option>
				@foreach ($artists as $artist)
					<option value="{{ $artist->id }}">{{ $artist->name }}</option>
				@endforeach
				</select>
			</div>
			<div class="col-md-5">
				{!! Form::label('category', 'Categorie', ['class' => 'custom-label']) !!}
				{!! Form::select('categorie', $newarray[1], 'Alle Categorieën', ['class' => 'form-control select2-select']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('genre', 'Genre', ['class' => 'custom-label']) !!}
				{!! Form::select('genre', $newarray[2], 'Alle Genres', ['class' => 'form-control select2-select']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('materiaal', 'Materiaal', ['class' => 'custom-label']) !!}
				{!! Form::select('materiaal', $newarray[4], 'Alle Materialen', ['class' => 'form-control select2-select']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('techniek', 'Techniek', ['class' => 'custom-label']) !!}
				{!! Form::select('techniek', $newarray[3], 'Alle Technieken', ['class' => 'form-control select2-select']) !!}
			</div>
			<div class="col-md-5" style="display: none">
				{!! Form::label('grootte', 'Grootte', ['class' => 'custom-label']) !!}
				{!! Form::select('grootte', array('Alle Grootte' => 'Alle Grootte', 'klein' => 'Klein', 'middelgroot' => 'Middelgroot', 'groot' => 'Groot'), null, ['class' => 'form-control select2-select']) !!}
			</div>

		</div>
	{!! Form::close() !!}
</div>
<script>
	$(document).ready(function() {
		$(".select2-select").select2();
	});
</script>