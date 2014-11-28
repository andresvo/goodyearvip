@extends('layoutadmin')

@section('content')

	<a href="{{ URL::to('/excel') }}">Descargar Excel</a>
	
	<div class="filtro">
		<div><strong>Ventas</strong></div>
		{{ Form::open(array('url' => 'admin')) }}
		{{ Form::select('id_usuario', $opciones, $id_usuario) }}
		{{ Form::submit('Filtrar') }}
		{{ Form::close() }}
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
			<td><a href="{{ URL::to('/compra/anular') . '/' . $compra->id }}" onclick="return confirm('¿Desea anular esta venta? La tarjeta recuperará su cupo anterior a la venta.')">Anular</a></td>
		</tr>
		@endforeach
		</table>
	@endif
@stop
