@extends('layout')

@section('content')

<div class="container muygrande">
	<img src="{{asset('assets/img/camara-ticket.png')}}" alt="Cámara" class="icon-float-camara">
	<h3 style="color:#FFC200; font-size:35px; margin-top:0">¡Participa por estos<div><b style="font-size: 36px;">increíbles premios!</b></div></h3>
	@if($enviado)
	Tus datos han sido enviados. Gracias por participar.
	@else
	<h4>Para concursar ingresa tus datos.</h4>
	{{ Form::open(array('url' => 'concursa')) }}
	<div class="row">
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Nombre" name="nombre"></input>
		</div>
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Mail" name="email"></input>
		</div>
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Marca de auto" name="marca"></input>
		</div>
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Modelo" name="modelo"></input>
		</div>
		<div class="form-group col-md-12">
			<input class="form-control" placeholder="Ciudad" name="ciudad"></input>
		</div>
		<div class="form-group col-md-12">
			<input type="submit" class="btn btn-block btn-primary" value="Participar">
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
	else if($('input[name=marca]').val() == '')  {alert('Por favor ingresa la marca de auto'); bValid = false;}
	else if($('input[name=modelo]').val() == '')  {alert('Por favor ingresa un modelo'); bValid = false;}
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
