@extends('admin/layoutadmin')

@section('content')

<div class="filtro">
	<div><strong>Tarjetas</strong></div>

</div>
	<p><a href="#" onclick="$('#nuevaemp').show()">Nueva empresa</a></p>

	@if(count($empresas) == 0)
		<table border="1">
		<tr>
			<th>No hay empresas registradas</th>
		</tr>
		</table>
	@else
		<table border="1">
		<tr>
			<th>Empresa</th>
			<th>Sufijo</th>
			<th>Tarjetas</th>
			<th>Rango</th>
			<th>Opciones</th>
		</tr>
		@foreach($empresas as $empresa)
		<tr>
			<td><a href="#" onclick="$('#r_id_empresa').val({{ $empresa->id }}); $('#renombrar').show()" class="linkoculto">{{ $empresa->nombre }}</a></td>
			<td>{{ $empresa->sufijo }}</td>
			<td>{{ $empresa->tarjetas }}</td>
			<td>{{ $empresa->minimo . ' - ' . $empresa->maximo }}</td>
			<td><a href="#" onclick="$('#t_id_empresa').val({{ $empresa->id }}); $('#creartarjetas').show()">Crear tarjetas</a></td>
		</tr>
		@endforeach
		</table>
	@endif

	<div id="creartarjetas">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#creartarjetas').hide(); return false;">X</a>
			Crear tarjetas para <span id="empresa-crear"></span>:
			<div class="bloque">
				{{ Form::open(array('url' => 'admin/tarjetas/crear')) }}
					<input type="hidden" value="" name="id_empresa" id="t_id_empresa">
					<input type="text" value="" name="cantidad" maxlength="4">
					<input type="submit" value="Crear" name="creartarjetas">
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<div id="nuevaemp">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#nuevaemp').hide(); return false;">X</a>
			Crear empresa:
			<div class="bloque">
				{{ Form::open(array('url' => 'admin/empresa/crear')) }}
					<input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Crear" name="nuevaemp">
				{{ Form::close() }}
			</div>
		</div>
	</div>

	<div id="renombrar">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#renombrar').hide(); return false;">X</a>
			Cambiar nombre:
			<div class="bloque">
				{{ Form::open(array('url' => 'admin/empresa/renombrar')) }}
					<input type="hidden" value="" name="id" id="r_id_empresa">
					<input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Guardar" name="guardar">
				{{ Form::close() }}
			</div>
		</div>
	</div>

@stop
