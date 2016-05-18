@extends('layout')

@section('content')

<div class="container distribuidores">
	@foreach($distribuidores as $dist)
		<div>
			<table><tr><td>
			<strong>{{ $dist->nombre }}</strong><br>
			{{ $dist->direccion }}<br>
			<strong>Teléfono</strong><br>
			{{ $dist->telefono }}<br>
			<strong>Web</strong> {{ $dist->web }}
			</td></tr></table>
		</div>
	@endforeach
</div>

@stop
