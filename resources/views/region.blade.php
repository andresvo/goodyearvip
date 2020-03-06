@extends('layout')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<h3>¿Cómo funciona?</h3>
				<ul class="list-custom">
					<li>Para hacer uso de los beneficios, el portador debe acercarse con su tarjeta a cualquier serviteca adherida al programa</li>
					<li>Cada tarjeta VIP tiene un código único al respaldo de la tarjeta</li>
					<li>Obtén un 20 % de descuento en todos los neumáticos de autos y camionetas Goodyear</li>
					<li>En el reverso de cada tarjeta se encontrará la vigencia</li>
					<li>Vive una experiencia de compra mejorada en atención y servicio</li>
				</ul>
			</div>
			<div class="col-lg-6">
				<h3>Encuentra tu serviteca<br><b>más cercana</b></h3>
				<form action="{{ url('distribuidores') }}" onsubmit="return validar()" method="post">
					{{ csrf_field() }}
					<div class="row">
						<div class="form-group col-md-12">
							<select name="region" id="region" class="form-control">
								<option value="0">Región</option>
							@foreach($regiones as $region)
								<option value="{{ $region->id }}">{{ $region->nombre }}</option>
							@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<select name="ciudad" id="ciudad" class="form-control">
								<option value="0">Ciudad</option>
							</select>
						</div>
						<div class="form-group col-md-6">
							<select name="comuna" id="comuna" class="form-control">
								<option value="0">Comuna</option>
							</select>
						</div>
						<div class="form-group col-md-12">
							<input type="submit" class="btn btn-block btn-primary" value="Consultar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function() {
			cargarCiudades();
		});


          $("#region").change(function() {
             cargarCiudades();
          });

          $("#ciudad").change(function() {
             cargarComunas();
          });


       	function cargarCiudades() {
			$.ajax({
                url: '{{ URL::to('/ciudad/listar') }}/' + $("#region").val(),
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                   $("#ciudad").html('<option>Buscando...</option>');
                },
                error: function() {
                   alert('Ha surgido un error.');
                },
                success: function(respuesta) {
                   if (respuesta) {
                   if(respuesta.length != 1) var html = '<option value="0">Ciudad</option>';
                   else var html = '';
                   respuesta.forEach(function(entry) {
						html += '<option value="' + entry.id + '">' + entry.nombre + '</option>';
					});

                      $("#ciudad").html(html);
                      cargarComunas();
                   } else {
                      $("#ciudad").html('<option>No se encontraron registros.</option>');
                   }
                }
             });

       	}

       	function cargarComunas() {
			$.ajax({
                url: '{{ URL::to('/comuna/listar') }}/' + $("#ciudad").val(),
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function() {
                   $("#comuna").html('<option>Buscando...</option>');
                },
                error: function() {
                   alert('Ha surgido un error.');
                },
                success: function(respuesta) {
                   if (respuesta) {
                   if(respuesta.length != 1) var html = '<option value="0">Comuna</option>';
                   else var html = '';
                   respuesta.forEach(function(entry) {
						html += '<option value="' + entry.id + '">' + entry.nombre + '</option>';
					});

                      $("#comuna").html(html);
                   } else {
                      $("#comuna").html('<option>No se encontraron registros. </option>');
                   }
                }
             });
       	}

   		function validar() {
			var valido = true;
			if($('#region').val() == '0') {alert('Por favor selecciona una región'); valido = false;}
			else if($('#ciudad').val() == '0') {alert('Por favor selecciona una ciudad'); valido = false;}
			else if($('#comuna').val() == '0') {alert('Por favor selecciona una comuna'); valido = false;}
			return valido;
		}

    </script>
@stop
