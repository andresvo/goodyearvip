@extends('layout')

@section('content')
<main class="grid lg:grid-cols-3">
	<div class="lg:col-span-2">
		<div class="hidden lg:block background-contacto lg:aspect-[1.6]"></div>
		<x-menu></x-menu>
		<div class="lg:hidden background-contacto aspect-[2.1]"></div>
	</div>
	<div class="p-8">
		<h3 class="my-4"><strong>Formulario de</strong> contacto</h3>
	@if($enviado)
	Tu comentario ha sido enviado. Gracias por contactarnos.
	@else
	<form action="{{ url('contacto') }}" method="post" class="form-contacto">
		@csrf
		<div class="row">
			<div class="form-group col-md-12">
				<input type="text" class="form-control" placeholder="Nombre" name="nombre" required />
			</div>
			<div class="form-group col-md-12">
				<input type="email" class="form-control" placeholder="Mail" name="email" required />
			</div>
			<div class="form-group col-md-12">
				<textarea class="form-control" placeholder="Comentario" name="comentario"  rows="4" cols="50" required></textarea>
			</div>
			<div class="form-group col-md-12">
				<input type="submit" class="btn" value="Enviar">
				<br><br><br>
				contacto@contactogoodyear.cl
			</div>
		</div>
	</form>
	@endif

</div>
</main>

@stop
