@extends('layout')

@section('content')
<div class="container form-pasos">
<h3>Paso 1<br><b>Ingreso de datos</b></h3>
@if(isset($error))
<p class="error">{{ $error }}</p>
@endif

<form action="{{ url('login') }}" method="post">
	{{ csrf_field() }}
	<div class="row">
	<div class="form-group col-md-12">
		<input class="form-control" type="text" name="email" placeholder="Ingresar usuario" />
	</div>
	<div class="form-group col-md-12">
		<input class="form-control" type="password" name="password" placeholder="Ingresar contraseña" />
	</div>
	<div class="form-group col-md-12">
		<input type="submit" class="btn btn-block btn-primary" value="Ingresar">
	</div>
	</div>
</form>
</div>

@stop
