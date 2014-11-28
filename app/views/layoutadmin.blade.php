<!DOCTYPE html>
<html lang="en">
<head>
	<title>Goodyear VIP</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.8">
	{{HTML::script('jquery-1.11.1.min.js')}}
	{{HTML::style('principal.css')}}
</head>
<body>
<div id="header">
</div>

<div class="contenido">
	<p style="float:right">
		<a href="{{ URL::to('/logout') }}">Cerrar sesión</a>
	</p>
	<h2>Administrador</h2>
	@yield('content')
</div>

<div id="footer">
</div>
</body>
</html>
