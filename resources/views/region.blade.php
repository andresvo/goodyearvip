@extends('layout')

@section('content')
<main class="grid lg:grid-cols-3">
	<div class="lg:col-span-2">
		<div class="background-person lg:aspect-[1.6]"></div>
		<x-menu></x-menu>
	</div>
	<div class="p-8">
		<h3 class="font-bold">¿Cómo funciona?</h3>
		<ul class="list-disc pl-5 text-gray mt-4 [&>li]:mb-2">
			<li>Para hacer uso del beneficio, el portador debe acercarse con su tarjeta a cualquier serviteca adherida al programa.</li>
			<li>Cada tarjeta VIP tiene un código único.</li>
			<li>Obtén un 20% de descuento en todos los neumáticos de autos y camioneta marca Goodyear.</li>
		</ul>
		<p class="text-gray font-bold mb-4">Vive una experiencia de compra única y mejorada en atención y servicio.</p>
		<h3 class="mt-12 leading-tight mb-4"><strong>Encuentra tu serviteca</strong><br>más cercana</h3>
		<form action="{{ url('distribuidores') }}" onsubmit="return validar()" method="post">
			{{ csrf_field() }}
			<div class="">
				<div class="form-group">
					<select name="region" id="region" class="form-control">
						<option value="0">Región</option>
					@foreach($regiones as $region)
						<option value="{{ $region->id }}">{{ $region->nombre }}</option>
					@endforeach
					</select>
				</div>
				<div class="form-group grid grid-cols-2 gap-4">
					<select name="ciudad" id="ciudad" class="form-control">
						<option value="0">Ciudad</option>
					</select>
					<select name="comuna" id="comuna" class="form-control">
						<option value="0">Comuna</option>
					</select>
				</div>
				<div class="form-group">
					<input type="submit" class="btn" value="Consultar">
				</div>
			</div>
		</form>
	</div>
</main>

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
                url: '{{ url('api/ciudad/listar') }}/' + $("#region").val(),
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
                url: '{{ url('api/comuna/listar') }}/' + $("#ciudad").val(),
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
