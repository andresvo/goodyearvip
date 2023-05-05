@extends('admin/layoutadmin')

@section('content')


	<div class="filtro">
		<div><strong>Ventas</strong></div>
		<form action="{{ url('admin') }}" method="post">
		{{ csrf_field() }}
		<select name="id_empresa" id="id_empresa">
			@foreach($opcionesemp as $i => $row)
				@if($i == $id_empresa)
				<option value="{{ $i }}" selected>{{ $row }}</option>
				@else
				<option value="{{ $i }}">{{ $row }}</option>
				@endif
			@endforeach
			</select> &nbsp;
			<select name="id_usuario" id="id_usuario">
			@foreach($opciones as $i => $row)
				@if($i == $id_usuario)
				<option value="{{ $i }}" selected>{{ $row }}</option>
				@else
				<option value="{{ $i }}">{{ $row }}</option>
				@endif
			@endforeach
			</select>
			<input type="submit" value="Filtrar">
		</form>
	</div>

	@if(count($compras) > 0)
		@if($id_empresa != null)
		<p><a href="{{ URL::to('/excel') . '/' . $id_empresa }}">Descargar Excel</a></p>
		@else
		<p><a href="{{ URL::to('/excel') }}">Descargar Excel</a></p>
		@endif
	@endif

	@if(count($compras) == 0)
		<table border="1">
		<tr>
			<th>No hay ventas registradas por {{ $opciones[$id_usuario] }}</th>
		</tr>
		</table>
	@else
		<table border="1">
		<tr>
			<th>Usuario</th>
			<th>Diseño</th>
			<th>Medida</th>
			<th>Cantidad</th>
			<th>Tarjeta</th>
			<th>Fecha creación</th>
			<th>Opciones</th>
		</tr>
		@foreach($compras as $compra)
		<tr>
			<td>{{ $compra->email }}</td>
			<td>{{ $compra->pnombre }}</td>
			<td>{{ $compra->mnombre }}</td>
			<td>{{ $compra->cantidad }}</td>
			<td>{{ $compra->codigo }}</td>
			<td>{{ $compra->created_at }}</td>
			<td><a href="{{ URL::to('/compra/anular') . '/' . $compra->id }}" onclick="return confirm('¿Desea anular esta venta? La tarjeta recuperará su cupo anterior a la venta.')">Anular</a></td>
		</tr>
		@endforeach
		</table>
	@endif
@stop
