@extends('layoutservi')

@section('content')

	@if (!isset($codigo))
		@if($mensaje != '')
			<p class="error">
				<span>Código de tarjeta no válido</span>
			</p>

		@endif
		{{ Form::open(array('url' => 'serviteca')) }}
			<input type="text" name="codigo" placeholder="Ingresar código" style="text-transform:uppercase" /><br>
			<input type="submit" value="Continuar" />
		{{ Form::close() }}

	@else

		@if ($cupo == 0)
			<p class="error">
				<a href="{{ URL::to('/serviteca') }}" class="x"></a>
				<span>Esta tarjeta tiene todos sus cupos de compra utilizados</span>
			</p>
		@else
		{{ Form::open(array('url' => 'compra/revisar', 'onsubmit' => 'return validar()', 'id' => 'venta')) }}
			<input type="hidden" name="id_tarjeta" value="{{ $id_tarjeta }}" />
			<select name="producto" id="producto">
				<option value="0">Selecciona diseño</option>
			@foreach($productos as $producto)
				<option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
			@endforeach
			</select>

			<select name="medida" id="medida">
				<option value="0">Selecciona medida</option>
			</select>

			<select name="cantidad" id="cantidad">
				<option value="0">Selecciona cantidad</option>
			@for($cant=$cupo;$cant>0;$cant--)
				<option value="{{ $cant }}">{{ $cant }}</option>
			@endfor
			</select><br>

			<input type="radio" name="bof" id="rboleta" value="b" checked="checked" />
			<input type="text" name="boleta" id="boleta" placeholder="Ingresa boleta" />

			<input type="radio" name="bof" id="rfactura" value="f" />
			<input type="text" name="factura" id="factura" placeholder="Ingresa factura" /><br>

			<input type="text" name="precio" id="precio" placeholder="Ingresa precio unitario" />
			<br>
			<input type="submit" value="Continuar" />
		{{ Form::close() }}
		@endif

	@endif

	<script type="text/javascript">
       (function() {
          $("#producto").change(function() {
             $.ajax({
                url: '{{ URL::to('/medida/listar') }}/' + $("#producto").val(),
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
