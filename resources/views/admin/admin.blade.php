@extends('admin/layoutadmin')

@section('content')


	<div class="filtro my-8">
		<form class="flex gap-x-2 my-4" action="{{ url('admin') }}" method="post">
		{{ csrf_field() }}
		<select name="id_empresa" id="id_empresa" class="small">
			@foreach($opcionesemp as $i => $row)
				@if($i == $id_empresa)
				<option value="{{ $i }}" selected>{{ $row }}</option>
				@else
				<option value="{{ $i }}">{{ $row }}</option>
				@endif
			@endforeach
			</select> &nbsp;
			<select name="id_usuario" id="id_usuario" class="small">
			@foreach($opciones as $i => $row)
				@if($i == $id_usuario)
				<option value="{{ $i }}" selected>{{ $row }}</option>
				@else
				<option value="{{ $i }}">{{ $row }}</option>
				@endif
			@endforeach
			</select>
			<input type="submit" class="bg-black text-white px-4 py-2 rounded-full" value="Filtrar">
			@if(count($compras) > 0)
				@if($id_empresa != null)
				<a class="bg-gold px-4 py-2 rounded-full whitespace-nowrap" href="{{ url('excel') . '/' . $id_empresa }}">Descargar Excel</a>
				@else
				<a class="bg-gold px-4 py-2 rounded-full whitespace-nowrap" href="{{ url('excel') }}">Descargar Excel</a>
				@endif
			@endif
		</form>
	</div>


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
			<td><a href="{{ url('/compra/anular') . '/' . $compra->id }}" onclick="return confirm('¿Desea anular esta venta? La tarjeta recuperará su cupo anterior a la venta.')">Anular</a></td>
		</tr>
		@endforeach
		</table>
	@endif
@stop
