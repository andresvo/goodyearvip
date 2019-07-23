@extends('admin/layoutadmin')

@section('content')

<div class="filtro">
	<div><a href="{{ URL::to('admin/productos') }}">Productos</a> &gt; <strong>Medidas de {{ $producto->nombre }}</strong></div>

</div>
	<p>
		<a href="#" onclick="$('#nuevamed').show()">Nueva medida</a>
	</p>

	@if(count($medidas) == 0)
		<table border="1">
		<tr>
			<th>No hay medidas registradas para este producto</th>
		</tr>
		</table>
	@else
		<table border="1">
		<tr>
			<th>Medida</th>
			<th>Opciones</th>
		</tr>
		@foreach($medidas as $medida)
		<tr>
			<td><a href="#" onclick="$('#r_id_medida').val({{ $medida->id }}); $('#renombrar').show()" class="linkoculto">{{ $medida->nombre }}</a></td>
			<td><a href="{{ URL::to('admin/medida/eliminar/'.$medida->id) }}" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar</a></td>
		</tr>
		@endforeach
		</table>
	@endif

	<div id="nuevamed" class="oculto">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#nuevamed').hide(); return false;">X</a>
			Crear medida:
			<div class="bloque">
				<form action="{{ url('admin/medida/crear/') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" value="{{ $producto->id }}" name="id_producto">
					Nombre: <input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Crear" name="nuevamed">
				</form>
			</div>
		</div>
	</div>

	<div id="renombrar" class="oculto">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#renombrar').hide(); return false;">X</a>
			Cambiar nombre:
			<div class="bloque">
				<form action="{{ url('admin/producto/renombrar') }}" method="post">
					<input type="hidden" value="" name="id" id="r_id_medida">
					<input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Guardar" name="guardar">
				</form>
			</div>
		</div>
	</div>

@stop
