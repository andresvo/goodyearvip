@extends('layout')

@section('content')

<div class="container">
	<div class="icon-float">
		<img src="{{ asset('assets/img/Icono_carrito de compra.svg') }}" alt="Carro de compras" class="icon-carro">
		<img src="{{ asset('assets/img/Logo cambia tu neumatico.svg') }}" alt="Cambia tu Neumático" class="icon-ctn">
	</div>
	<h3><b>Compra tus neumáticos</b><br>en línea</h3><br>
	<p>Pensando en tu bienestar, podrás adquirir de manera fácil, rápida y cómoda tus neumáticos por
	internet. Si tienes dudas, contáctanos y te asesoraremos con el proceso.</p>
	<br>
	<ol class="list-custom">
		<li><strong>Encuentra tus neumáticos:</strong> A través del botón “Busca tu neumático”.</li>
		<li><strong>Selecciónalos:</strong> Indica cuales vas a comprar y la cantidad que necesitas.</li>
		<li><strong>Agenda la instalación:</strong> Elige cuándo y dónde (podrás optar por despacho a domicilio
	o Instalación en un taller).</li>
		<li><strong>Indica la forma de pago:</strong> Selecciona el método de pago de tu conveniencia.
	(Débito, tarjeta crédito o transferencia).</li>
		<li><strong>Obtén tu descuento:</strong> Ingresa el código que aparece en tu tarjeta para disfrutar de este	beneficio.</li>
	</ol>
	<p><strong>¡Vive una experiencia de compra mejorada en atención y servicio!</strong></p>
	<br>
	<div>
		<ul class="contacto-ctn">
		<li>
				<img src="{{ asset('assets/img/icono celular.svg') }}" alt="">
				<strong>Call Center</strong><br>
				2 2993 7710
			</li>
			<li>
				<img src="{{ asset('assets/img/icono whatsapp.svg') }}" alt="">
				<strong>Whatsapp</strong><br>
				996923287
			</li>
			<li>
				<img src="{{ asset('assets/img/icono mail.svg') }}" alt="">
				<strong>Email</strong><br>
				contacto@cambiatuneumatico.com
			</li>
		</ul>
	</div>
	<p>
		<a href="#" class="btn btn-primary">Encuentra aquí tu neumático</a>
	</p>
</div>

@stop
