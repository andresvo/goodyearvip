@extends('layout')

@section('content')

<div class="container">
	<img src="{{asset('assets/img/carta-icon.png')}}" alt="Carta" class="icon-float-carta" style="padding-right: 100px;">
	<h3>Formulario<br><b>de contacto</b></h3>
	@if($enviado)
	Tu comentario ha sido enviado. Gracias por contactarnos.
	@else
	{{ Form::open(array('url' => 'contacto')) }}
		<div class="row">
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Nombre" name="nombre"></input>
		</div>
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Mail" name="email"></input>
		</div>
		<div class="form-group col-md-12">
			<textarea class="form-control" placeholder="Comentario" name="comentario"  rows="4" cols="50"></textarea>
		</div>
		<div class="form-group col-md-12">
			<input type="submit" class="btn btn-block btn-primary" value="Enviar">
			<br>
			clientevipgoodyear@clientevipgoodyear.cl
		</div>
		</div>
	{{ Form::close() }}
	@endif
</div>

<script>
$('form').submit(function(event){
	event.preventDefault();
	var bValid = true;
	if($('input[name=nombre]').val() == '')  {alert('Por favor ingresa tu nombre'); bValid = false;}
	else if(!checkEmail( $('input[name=email]').val())) { alert("Por favor ingresa un email válido"); bValid = false; }
	else if($('textarea[name=comentario]').val() == '')  {alert('Por favor ingresa un comentario'); bValid = false;}
	if(bValid) $('form').submit();
});

function checkEmail( o ) {
	return checkRegexp( o, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i );
}
function checkRegexp( o, regexp ) {
	if ( !( regexp.test( o ) ) ) {
		return false;
	} else {
		return true;
	}
}
</script>

@stop
