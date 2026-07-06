@extends('layout')

@section('content')

<main class="grid lg:grid-cols-3">
	<div class="lg:col-span-2">
		<div class="hidden lg:block background-login aspect-[1.6]"></div>
		<x-menu></x-menu>
		<div class="lg:hidden background-login aspect-[2.1]"></div>
	</div>
	<div class="p-8">
	@if(isset($ingresada))
		<h3>Listo</h3>
		<p class="my-8">
			<span>La venta ha sido registrada</span>
		</p>
		<p class="flex gap-x-4">
			<a href="{{ url('/serviteca') }}" class="bg-gold text-black rounded-full px-4 py-2 mr-4">Registrar otra venta</a>
			<a href="{{ url('/logout') }}" class="bg-black text-white rounded-full px-4 py-2">Cerrar sesión</a>
		</p>

	@else
		<h3>Paso 4<br><b>Confirmación</b></h3>
		<form action="{{ url('compra/crear') }}" method="post">
		{{ csrf_field() }}

		<div class="row">
		<div class="form-group col-md-12">
			<a href="{{ url('/serviteca') }}" class="x" onclick="$('#volver').submit();return false"></a>
			<div id="revisar">
			<table class="revisar">
				<tr>
				<td>Diseño : </td><td style="text-align:left">{{ $producto->nombre }}</td>
				</tr>
				<tr>
				<td>Medida : </td><td style="text-align:left">{{ $medida->nombre }}</td>
				</tr>
				<tr>
				<td>Cantidad : </td><td style="text-align:left">{{ $cantidad }}</td>
				</tr>
				<tr>
				<td>Boleta : </td><td style="text-align:left">{{ $boleta }}</td>
				</tr>
				<tr>
				<td>Factura : </td><td style="text-align:left">{{ $factura }}</td>
				</tr>
				<tr>
				<td>Precio unitario : </td><td style="text-align:left">{{ $precio }}</td>
				</tr>
			</table>
			</div>
		</div>
		</div>


			<input type="hidden" name="id_tarjeta" value="{{ $id_tarjeta }}" />
			<input type="hidden" name="producto" value="{{ $producto->id }}" />
			<input type="hidden" name="medida" value="{{ $medida->id }}" />
			<input type="hidden" name="cantidad" value="{{ $cantidad }}" />
			<input type="hidden" name="boleta" value="{{ $boleta }}" />
			<input type="hidden" name="factura" value="{{ $factura }}" />
			<input type="hidden" name="precio" value="{{ $precio }}" />
			<div class="form-group col-md-12">
				<input type="submit" class="btn btn-block btn-primary" value="Ingresar" />
			</div>
		</form>

		<form action="{{ url('serviteca') }}" id="volver">
			{{ csrf_field() }}
			<input type="hidden" name="codigo" value="{{ $codigo }}" />
		</form>

	@endif
</main>

@stop
