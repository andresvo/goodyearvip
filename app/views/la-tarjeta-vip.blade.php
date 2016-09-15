@extends('layout')

@section('content')

<div class="container grande">
<img src="assets/img/vip-icon.png" alt="VIP" class="icon-float">
<h3>La tarjeta<br><div style="color:#FFC200">cliente VIP</div></h3><br>

<p>Si eres portador de una de estas tarjetas, ya eres parte del programa Cliente VIP Goodyear, enfocado en entregar una excelente experiencia a nuestros clientes en todas las servitecas adheridas al programa. El usuario de la tarjeta podrá contar con un descuento de un 20% en la compra de sus neumáticos, además de recibir una excelente atención en nuestros puntos de venta.</p>

<p>Los invitamos a navegar en el sitio de Cliente VIP y descubrir los beneficios y detalles del programa. También podrás descubrir cómo utilizar la tarjeta VIP de Goodyear. </p>

<div class="row">
	<div class="col-md-offset-6 col-md-6">
	<a class="btn btn-sm btn-primary btn-block" href="{{ URL::to('/descargas') }}/bases.pdf" target="_blank">Ver Bases</a>
	</div>
</div>
</div>

@stop
