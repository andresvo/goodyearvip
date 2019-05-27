<!DOCTYPE html>
<html lang="en">
<head>
	<title>Goodyear VIP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.8">
	{{HTML::script('jquery-1.11.1.min.js')}}
	{{HTML::style('principal.css?v=3')}}
</head>
<body>

<div class="contenido">
	<p style="float:right">
		<a href="{{ URL::to('/logout') }}">Cerrar sesión</a>
	</p>
	<h2>Administrador</h2>

	<nav>
		<a href="{{ URL::to('admin') }}">Ventas</a>
		<a href="{{ URL::to('admin/tarjetas') }}">Tarjetas</a>
		<a href="{{ URL::to('admin/concurso') }}">Concurso</a>
		<a href="{{ URL::to('admin/productos') }}">Productos</a>
	</nav>
	@yield('content')
</div>

<div id="footer">
</div>
</body>
</html>
