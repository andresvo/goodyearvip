@extends('layout')

@section('content')

<div class="container">
	<div class="icon-float">
		<img src="{{ asset('assets/img/Icono_carrito de compra.svg') }}" alt="Carro de compras" class="icon-carro">
	</div>
	<h3><b>Compra tus neumáticos</b><br>en línea</h3><br>
	<p>Adquiere de manera fácil, rápida y cómoda tus neumáticos por
	internet. Si tienes dudas, contáctanos y te asesoraremos con el proceso.</p>
	<br>
	<ol class="list-custom">
		<li>Pincha el botón encuentra tus neumáticos.</li>
		<li>Indica cuáles y cuántos neumáticos necesitas.</li>
		<li>Elige cuándo y dónde instalar tus neumáticos (podrás optar por despacho a domicilio	o instalación en un taller).</li>
		<li>Ingresa el código que aparece en tu tarjeta para obtener tu descuento.</li>
		<li>Elige la forma de pago de tu conveniencia (Débito, tarjeta crédito o transferencia).</li>
	</ol>
	<p><strong>¡Vive una experiencia de compra mejorada!</strong></p>
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
				clientevipgoodyear@clientevipgoodyear.cl
			</li>
		</ul>
	</div>
	<p>
		<a href="#" class="btn btn-primary" style="position: relative; top: -14px;">Encuentra aquí<br>tu neumático</a>
	</p>
</div>

@stop
