@extends('admin/layoutadmin')

@section('content')

<div class="filtro">
	<p class="my-8">
		<a href="#" onclick="$('#nuevoprod').show()" class="bg-black text-white px-4 py-2 rounded-full inline-block">Nuevo producto</a>
	</p>

	@if(count($productos) == 0)
		<table border="1">
		<tr>
			<th>No hay productos registrados</th>
		</tr>
		</table>
	@else
		<table border="1">
		<tr>
			<th>Diseño</th>
			<th>Activo</th>
			<th>Opciones</th>
		</tr>
		@foreach($productos as $producto)
		<tr>
			<td><a href="#" onclick="$('#r_id_empresa').val({{ $producto->id }}); $('#renombrar').show()" class="linkoculto">{{ $producto->nombre }}</a></td>
			<td>{{ intval($producto->activo) }}</td>
			<td>
				<a href="{{ url('admin/medidas/'.$producto->id) }}">Ver medidas</a> |
				<a href="#" onclick="editar({{ $producto->id }})">Editar</a> |
				<a href="{{ url('admin/producto/eliminar/'.$producto->id) }}" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar</a>
			</td>
		</tr>
		@endforeach
		</table>
	@endif

	<div id="nuevoprod" class="oculto">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#nuevoprod').hide(); return false;">X</a>
			Crear producto:
			<div class="bloque">
				<form action="{{ url('admin/producto/crear') }}" method="post">
					{{ csrf_field() }}
					Diseño: <input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Crear" name="nuevoprod" class="bg-black text-white px-4 py-2 rounded-full inline-block">
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
				<form action="{{ url('admin/producto/editar') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" value="" name="id" id="r_id_producto">
					<input type="text" value="" id="r_nombre" name="nombre" size="40"><br>
					<p class="my-2"><input type="checkbox" name="activo" id="r_activo" value="1"><label class="inline text-base" for="r_activo"> Activo</label> </p>
					<input type="submit" value="Guardar" name="guardar" class="bg-black text-white px-4 py-2 rounded-full inline-block">
				</form>
			</div>
		</div>
	</div>
</div>

<script>
productos = {!! json_encode($opcionesprod) !!};

function editar(id_producto) {
	$('#r_id_producto').val(id_producto);
	$('#r_nombre').val(productos[id_producto].nombre);
	if(productos[id_producto].activo == 1) $('#r_activo').attr('checked', true);
	else $('#r_activo').attr('checked', false);
	$('#renombrar').show();
}
</script>

@stop
