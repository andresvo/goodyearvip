@extends('layout')

@section('content')
	<div class="container">
	<h3>Encuentra tu serviteca<br><b>más cercana</b></h3>
	{{ Form::open(array('url' => 'distribuidores', 'onsubmit' => 'return validar()')) }}
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
		<div class="form-group col-md-12">
			<img src="assets/img/20-dscto.png" width="100%">
		</div>
		</div>
	{{ Form::close() }}
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
