@extends('layout')

@section('content')
<main class="grid lg:grid-cols-3">
	<div class="lg:col-span-2">
		<div class="background-login lg:aspect-[1.6]"></div>
		<x-menu></x-menu>
	</div>
	<div class="p-8">
		<h3 class="mb-4">Paso 1<br><b>Ingresa</b> datos de acceso</h3>
		@if(isset($error))
			<p class="error">{{ $error }}</p>
		@endif

		<form action="{{ url('login') }}" method="post">
			{{ csrf_field() }}
			<div class="">
				<div class="form-group mb-4">
					<input class="form-control" type="text" name="email" placeholder="Ingresar usuario" />
				</div>
				<div class="form-group mb-4">
					<input class="form-control" type="password" name="password" placeholder="Ingresar contraseña" />
				</div>
				<div class="form-group mt-8">
					<input type="submit" class="btn" value="Ingresar">
				</div>
			</div>
		</form>
	</div>
</main>
@stop
