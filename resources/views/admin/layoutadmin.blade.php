<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.8">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Cliente VIP Goodyear</title>

	@vite('resources/css/app.css')

	<script type="text/javascript" src="{{ asset('jquery-1.11.1.min.js') }}"></script>
</head>
<body>

	<header class="flex justify-center items-center pt-4 pb-6">
		<a href="{{ url('/') }}" class="flex justify-center items-center gap-x-4">
			<h1 class="text-3xl font-normal pt-2">Programa <strong>CLIENTE VIP</strong></h1> <img class="w-60" src="{{ asset('img/logo-goodyear.svg') }}" alt="Goodyear">
		</a>
	</header>

<main class="contenido mx-auto max-w-5xl">
	<div class="flex justify-between gap-x-4 my-4">
		<h2 class="bg-gray rounded-full p-2 text-3xl text-white text-center uppercase flex-1">Administrador</h2>
		<a href="{{ url('logout') }}" class="bg-black text-white rounded-full px-4 py-2 w-[192px] flex items-center justify-center">Cerrar sesión</a>
	</div>

	<x-menu-admin />
	
	@yield('content')
</main>

</body>
</html>
