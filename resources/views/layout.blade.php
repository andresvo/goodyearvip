<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">

  <title>Cliente VIP Goodyear</title>

	@vite('resources/css/app.css')

	<script type="text/javascript" src="{{ asset('jquery-1.11.1.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA5HcGlu9gQbQRE3THOh7KvWK5Q_9kod0Q"></script>
<script>
    var styles = [
      {
        "featureType": "road.arterial",
        "elementType": "geometry.fill",
        "stylers": [
          { "color": "#fee100" }
        ]
      },{
        "featureType": "road.arterial",
        "elementType": "geometry.stroke",
        "stylers": [
          { "color": "#0c3a74" }
        ]
      },{
        "featureType": "road.local",
        "elementType": "geometry.fill",
        "stylers": [
          { "color": "#fee100" }
        ]
      },{
        "featureType": "road.local",
        "elementType": "geometry.stroke",
        "stylers": [
          { "color": "#0c3a74" }
        ]
      }
    ];
</script>
</head>
<body>
<?php $ruta = Request::url(); $sufijo = ''; ?>

	<header class="flex justify-center items-center pt-4 pb-6">
		<a href="{{ url('/') }}" class="flex justify-center items-center gap-x-4">
			<h1 class="text-3xl font-normal pt-2">Programa <strong>CLIENTE VIP</strong></h1> <img class="w-60" src="{{ asset('img/logo-goodyear.svg') }}" alt="Goodyear">
		</a>
	</header>

  @yield('content')

	<footer class="footer">
		<div class="franja-blanca">
			Cliente Vip es un programa exclusivo para clientes Goodyear
		</div>
	</footer>

<script type="text/javascript"></script>
<script>
  $(function () {
    $('#opcion4').tooltip({
      template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner glb-01"></div></div>'
    })
  })
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-58028509-2', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
