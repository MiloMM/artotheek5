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
				{!! Form::select('kunstenaar', $newarray[1], 'Alle Kunstenaars', ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('onderwerp', 'Onderwerp', ['class' => 'custom-label']) !!}
				{!! Form::select('onderwerp', $newarray[3], 'Alle Onderwerpen', ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('materiaal', 'Materiaal', ['class' => 'custom-label']) !!}
				{!! Form::select('materiaal', $newarray[4], 'Alle Materialen', ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('techniek', 'Techniek', ['class' => 'custom-label']) !!}
				{!! Form::select('techniek', $newarray[5], 'Alle Technieken', ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('kleur', 'Kleur', ['class' => 'custom-label']) !!}
				{!! Form::select('kleur', $newarray[2], 'Alle Kleuren', ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-5">
				{!! Form::label('grootte', 'Grootte', ['class' => 'custom-label']) !!}
				{!! Form::select('grootte', array('Alle Grootte' => 'Alle Grootte', 'klein' => 'Klein', 'middelgroot' => 'Middelgroot', 'groot' => 'Groot'), null, ['class' => 'form-control']) !!}
			</div>

		</div>
	{!! Form::close() !!}

</div>
