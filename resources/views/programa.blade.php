@extends('layout')

@section('content')

<div class="container">
	<h3><b>Programa</b> Cliente VIP <img src="{{ asset('assets/img/Icono_tarjeta vip.svg') }}" alt="" class="icon-tarjeta"></h3><br>
	<p>Si eres portador de una de estas tarjetas, ya eres parte del programa Cliente VIP Goodyear,
enfocado en entregar una experiencia de compra mejorada para que puedas adquirir los
neumáticos Goodyear para auto y camioneta ideales para tu vehículo con descuentos preferenciales, 
además de otros beneficios como el despacho, instalación y balanceo en el lugar de tu
conveniencia, ya sea a domicilio o en un taller.</p>
<br><br>
	<div>
		<div class="row font-trade">
			<div class="col-md-6 text-center">
				<a href="{{ url('compra-online') }}" class="btn btn-primary">Compra tus neumáticos<br>en línea</a><br><br>
				(DESDE LA COMODIDAD DE TU<br>
				CASA O LUGAR DE TRABAJO)
			</div>
			<div class="col-md-6 text-center">
				<a href="{{ url('compra-en-servitecas') }}" class="btn btn-primary">Compra directo<br>en una serviteca</a><br><br>
				(REVISA AQUÍ LAS SERVITECAS<br>
				ADHERIDAS AL PROGRAMA)
			</div>
		</div>
	</div>
</div>

@stop
