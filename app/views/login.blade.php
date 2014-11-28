@extends('layoutservi')

@section('content')

	@if(isset($error))
	<p class="error">{{ $error }}</p>
	@endif
	
	{{ Form::open(array('url' => 'login')) }}
		<input type="text" name="email" placeholder="Ingresar usuario" /><br>
		<input type="password" name="password" placeholder="Ingresar contraseña" /><br>

		<input type="submit" value="Ingresar" />
	{{ Form::close() }}

@stop
