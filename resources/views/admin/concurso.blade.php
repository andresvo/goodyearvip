@extends('admin/layoutadmin')

@section('content')

<div class="filtro">
	<div><strong>Concurso</strong></div>

</div>
	@if(count($concursantes) == 0)
		<table border="1">
		<tr>
			<th>No hay concursantes registrados</th>
		</tr>
		</table>
	@else
		<table border="1">
		<tr>
			<th>Fecha</th>
			<th>Nombre</th>
			<th>Email</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Opciones</th>
		</tr>
		@foreach($concursantes as $c)
		<tr>
			<td>{{ $c->created_at }}</td>
			<td>{{ $c->nombre }}</td>
			<td>{{ $c->email }}</td>
			<td>{{ $c->marca }}</td>
			<td>{{ $c->modelo }}</td>
			<td><a href="{{ URL::to('admin/concursante/eliminar/' . $c->id) }}" onclick="return confirm('¿Seguro desea eliminar?')">eliminar</a></td>
		</tr>
		@endforeach
		</table>
	@endif

@stop
