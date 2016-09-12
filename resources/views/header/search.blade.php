<div id="custom_searchmenu" class="custom_searchmenu">
	<img class="site_logo_menu" src="{{ asset('images/Galleria_logo_small.png') }}">
	{!! Form::open(array('url' => 'gallery/search', 'method' => 'get', 'required')) !!}
		{!! Form::token() !!}

		{!! Form::text('keyword', null, ['class' => 'form-control', 'placeholder' => 'Zoek naar kunstwerken']) !!}
		<p class="expandtext" id="expandtext">Filters Weergeven</p>
		<div class="filter-box" id="filterbox">
			<div class="col-md-12">
				{!! Form::label('kunstenaar', 'Kunstenaar', ['class' => 'custom-label']) !!}
				{!! Form::select('kunstenaar', $newarray[1], null, ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-12">
				{!! Form::label('onderwerp', 'Onderwerp', ['class' => 'custom-label']) !!}
				{!! Form::select('onderwerp', $newarray[3], null, ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-12">
				{!! Form::label('materiaal', 'Materiaal', ['class' => 'custom-label']) !!}
				{!! Form::select('materiaal', $newarray[4], null, ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-12">
				{!! Form::label('techniek', 'Techniek', ['class' => 'custom-label']) !!}
				{!! Form::select('techniek', $newarray[5], null, ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-12">
				{!! Form::label('kleur', 'Kleur', ['class' => 'custom-label']) !!}
				{!! Form::select('kleur', $newarray[2], null, ['class' => 'form-control']) !!}
			</div>
			<div class="col-md-12">
				{!! Form::label('grootte', 'Grootte', ['class' => 'custom-label']) !!}
				{!! Form::select('grootte', array('Alle Grootte' => 'Alle Grootte', 'klein' => 'Klein', 'middelgroot' => 'Middelgroot', 'groot' => 'Groot'), null, ['class' => 'form-control']) !!}
			</div>
			
			
		</div>
	{!! Form::close() !!}

</div>