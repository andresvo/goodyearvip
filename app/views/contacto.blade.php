@extends('layout')

@section('content')

<div class="container">
	<img src="{{asset('assets/img/carta-icon.png')}}" alt="Carta" class="icon-float-carta" style="padding-right: 100px;">
	<h3>Formulario<br><b>de contacto</b></h3>
	<form action="" method="post">
		<div class="row">
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Nombre" name="nombre"></input>
		</div>
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Mail" name="mail"></input>
		</div>
		<div class="form-group col-md-12">
			<textarea class="form-control" placeholder="Comentario" name="comentario"  rows="4" cols="50"></textarea>
		</div>
		<div class="form-group col-md-12">
			<button type="submit" class="btn btn-block btn-primary">Enviar</button>
		</div>
		</div>
	</form>
</div>

@stop
