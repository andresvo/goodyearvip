@extends('layout')

@section('content')

<div class="container form-pasos">
	@if(isset($ingresada))
		<h3>Listo</h3>
		<p class="error">
			<a href="{{ URL::to('/serviteca') }}" class="x"></a>
			<span>La venta ha sido registrada</span>
		</p>
			<p><a href="{{ URL::to('/logout') }}" class="fuera">Cerrar sesión</a></p>

	@else
		<h3>Paso 4<br><b>Confirmación</b></h3>
		{{ Form::open(array('url' => 'compra/crear')) }}
		<div class="row">
		<div class="form-group col-md-12">
			<a href="{{ URL::to('/serviteca') }}" class="x" onclick="$('#volver').submit();return false"></a>
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
		{{ Form::close() }}

		{{ Form::open(array('url' => 'serviteca', 'id' => 'volver')) }}
			<input type="hidden" name="codigo" value="{{ $codigo }}" />
		{{ Form::close() }}

	@endif
</div>

@stop
