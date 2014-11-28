@extends('layout')

@section('content')
	{{ Form::open(array('url' => 'distribuidores', 'onsubmit' => 'return validar()')) }}
		
		<select name="region" id="region">
			<option value="0">Selecciona región</option>
		@foreach($regiones as $region)
		    <option value="{{ $region->id }}">{{ $region->nombre }}</option>
		@endforeach
		</select>
		
		<select name="ciudad" id="ciudad">
			<option value="0">Selecciona ciudad</option>
		</select>
		
		<select name="comuna" id="comuna">
			<option value="0">Selecciona comuna</option>
		</select>
		
		<input type="submit" value="Continuar" />
	{{ Form::close() }}
	
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
                   if(respuesta.length != 1) var html = '<option value="0">Selecciona ciudad</option>';
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
                   if(respuesta.length != 1) var html = '<option value="0">Selecciona comuna</option>';
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
