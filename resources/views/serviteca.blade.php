@extends('layout')

@section('content')

<main class="grid lg:grid-cols-3">
	<div class="lg:col-span-2">
		<div class="hidden lg:block background-login aspect-[1.6]"></div>
		<x-menu></x-menu>
		<div class="lg:hidden background-login aspect-[2.1]"></div>
	</div>
	<div class="p-8">

	@if (!isset($codigo))
		<h3 class="mb-4">Paso 2<br><b>Ingreso de código</b></h3>
		@if($mensaje != '')
			<p class="error">
				<span>Código de tarjeta no válido</span>
			</p>

		@endif
		<form action="{{ url('serviteca') }}">
			<div class="row">
				<div class="form-group">
					<input class="form-control" type="text" name="codigo" placeholder="Ingresar código" style="text-transform:uppercase" />
				</div>
				<div class="form-group mt-8">
					<input type="submit" class="btn btn-block btn-primary" value="Continuar">
				</div>
			</div>
		</form>

	@else
		<h3 class="mb-4">Paso 3<br><b>Detalle de venta.</b></h3>
		@if ($cupo == 0)
			<p class="error">
				<a href="{{ url('/serviteca') }}" class="x"></a>
				<span>Esta tarjeta tiene todos sus cupos de compra utilizados</span>
			</p>
		@else
		<form action="{{ url('compra/revisar') }}" onsubmit="return validar()" id="venta" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="id_tarjeta" value="{{ $id_tarjeta }}" />
		<div class="grid lg:grid-cols-2 gap-4">
				<select class="lg:col-span-2" name="producto" id="producto">
					<option value="0">Selecciona diseño</option>
				@foreach($productos as $producto)
					<option value="{{ $producto->id }}">{{ $producto->marca . ' ' . $producto->nombre }}</option>
				@endforeach
				</select>
				<select name="medida" id="medida" class="form-control">
					<option value="0">Selecciona medida</option>
				</select>
				<select name="cantidad" id="cantidad" class="form-control">
					<option value="0">Selecciona cantidad</option>
				@for($cant=$cupo;$cant>0;$cant--)
					<option value="{{ $cant }}">{{ $cant }}</option>
				@endfor
				</select>
			<div class="flex items-center gap-2">
				<input type="radio" name="bof" id="rboleta" value="b" checked="checked" />
				<input type="text" class="form-control" name="boleta" id="boleta" placeholder="Ingresa boleta" />
			</div>
			<div class="flex items-center gap-2">
				<input type="radio" name="bof" id="rfactura" value="f" />
				<input type="text" class="form-control" name="factura" id="factura" placeholder="Ingresa factura" />
			</div>
				<input type="text" class="lg:col-span-2" name="precio" id="precio" placeholder="Ingresa precio unitario (precio a público de lista)" />
				<input type="submit" class="btn lg:col-span-2" value="Continuar" >
		</div>
	</form>

	@endif

	@endif
</main>

	<script type="text/javascript">
       (function() {
          $("#producto").change(function() {
             $.ajax({
                url: '{{ url('api/medida/listar') }}/' + $("#producto").val(),
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                   $("#medida").html('<option>Buscando...</option>');
                },
                error: function() {
                   alert('Ha surgido un error.');
                },
                success: function(respuesta) {
                   if (respuesta) {
                   var html = '<option value="0">Selecciona medida</option>';
                   respuesta.forEach(function(entry) {
						html += '<option value="' + entry.id + '">' + entry.nombre + '</option>';
					});

                      $("#medida").html(html);
                   } else {
                      $("#medida").html('<option>No se encontraron registros.</option>');
                   }
                }
             });

          });

             $('#boleta').focus(function() {
             	$('#rfactura').prop( "checked", false );
             	$('#rboleta').prop( "checked", true );
             	$('#factura').val('');
             });
             $('#factura').focus(function() {
             	$('#rboleta').prop( "checked", false );
             	$('#rfactura').prop( "checked", true );
             	$('#boleta').val('');
             });

             $('#rboleta').click(function() {
             	$('#boleta').focus();
             });
             $('#rfactura').click(function() {
             	$('#factura').focus();
             });

       }).call(this);

		function validar() {
			var valido = true;
			if($('#producto').val() == '0') {alert('Por favor elige un diseño'); valido = false;}
			else if($('#medida').val() == '0') {alert('Por favor selecciona una medida'); valido = false;}
			else if($('#cantidad').val() == '0') {alert('Por favor selecciona la cantidad'); valido = false;}
			else if($('#boleta').val() == '' && $('#factura').val() == '') {alert('Por favor ingresa número de boleta o factura'); valido = false;}
			else if($('#precio').val() == '') {alert('Por favor ingresa el precio unitario'); valido = false;}
			return valido;
		}
    </script>
@stop
