@extends('app')

@section('content')
<div class="container accountsPage">
	<div class="col-md-12">
		<h1>Accountbeheer<h1>
	</div>
	<div class="col-md-4">
		<h4>Gebruikers zonder speciale rechten</h2>
		@foreach ($users['users'] as $user)
			<div class="col-md-12">
				<a href="/users/{{ $user->slug }}" class="artist">{{ $user->name }}</a>
				<a class="fa fa-pencil-square-o filter-options" href="/users/{{ $user->slug }}/edit"title="Wijzigen"></a>
				<a class="fa fa-trash filter-options" href="/users/destroy/{{ $user->userId }}" title="Verwijderen" onclick="return confirm('Weet u zeker dat u dit profiel/account wilt verwijderen? De kunstenaar die aan dit profiel is gekoppeld blijft bestaan.')"></a>
			</div>
		@endforeach
	</div>
	<div class="col-md-4">
		<h4>Gebruikers met kunstenaarsrechten</h2>
		@foreach ($users['artists'] as $user)
			<div class="col-md-12">
				<a href="/users/{{ $user->slug }}" class="artist">{{ $user->name }}</a>
				<a class="fa fa-pencil-square-o filter-options" href="/users/{{ $user->slug }}/edit"title="Wijzigen"></a>
				<a class="fa fa-trash filter-options" href="/users/destroy/{{ $user->userId }}" title="Verwijderen" onclick="return confirm('Weet u zeker dat u dit profiel/account wilt verwijderen? De kunstenaar die aan dit profiel is gekoppeld blijft bestaan.')"></a>
			</div>
		@endforeach
	</div>
	<div class="col-md-4">
		<h4>Administratoren</h2>
		@foreach ($users['administrators'] as $user)
			<div class="col-md-12">
				<a href="/users/{{ $user->slug }}" class="artist">{{ $user->name }}</a>
				<a class="fa fa-pencil-square-o filter-options" href="/users/{{ $user->slug }}/edit"title="Wijzigen"></a>
				@if (Auth::user()->id != $user->id)
					<a class="fa fa-trash filter-options" href="/users/destroy/{{ $user->useId }}" title="Verwijderen" onclick="return confirm('Weet u zeker dat u dit profiel/account wilt verwijderen? De kunstenaar die aan dit profiel is gekoppeld blijft bestaan.')"></a>
				@endif
			</div>
		@endforeach
	</div>
</div>
@endsection