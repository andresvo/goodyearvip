@extends('admin/layoutadmin')

@section('content')

<div class="filtro">
	<div><strong>Diseños de Tarjeta</strong></div>

</div>
	<p><a href="#" onclick="$('#nuevodiseno').show()">Nuevo diseño</a></p>

	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif

	@if(count($disenos) == 0)
		<table border="1">
		<tr>
			<th>No hay diseños disponibles</th>
		</tr>
		</table>
	@else
		<table border="1">
		<tr>
			<th>Nombre</th>
			<th>Imagen</th>
			<th>Opciones</th>
		</tr>
		@foreach($disenos as $diseno)
		<tr>
			<td><a href="#" onclick="renombrarDiseno({{ $diseno->id }}, '{{ $diseno->nombre }}')" class="linkoculto">{{ $diseno->nombre }}</a></td>
			<td><img src="{{ $diseno->imagen }}" width="300" alt="Tarjeta"></td>
			<td>
				<a href="{{ url('admin/diseno/eliminar/' . $diseno->id) }}" onclick="return confirm('¿Confirma eliminación de {{ $diseno->nombre }}?')">Eliminar</a>
			</td>
		</tr>
		@endforeach
		</table>
	@endif

	<div id="nuevodiseno" class="oculto">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#nuevodiseno').hide(); return false;">X</a>
			Crear diseño:
			<div class="bloque">
				<form action="{{ url('admin/diseno/crear') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					Nombre:<br>
					<input type="text" value="" id="nombre" name="nombre" required><br>
					Imagen (PNG 720px de ancho):<br>
					<input name="imagen" type="file" accept=".png" required /><br><br>
					<input type="submit" value="Crear" name="nuevodiseno">
				</form>
			</div>
		</div>
	</div>

	<div id="renombrar">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#renombrar').hide(); return false;">X</a>
			Cambiar nombre:
			<div class="bloque">
				<form action="{{ url('admin/diseno/renombrar') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" value="" name="id" id="r_id_diseno">
					<input type="text" value="" id="r_nombre" name="nombre">
					<input type="submit" value="Guardar" name="guardar">
				</form>
			</div>
		</div>
	</div>

	

<script>
function renombrarDiseno(id, nombre) {
	$('#r_id_diseno').val(id); 
	$('#r_nombre').val(nombre); 
	$('#renombrar').show()
}
</script>

@stop
