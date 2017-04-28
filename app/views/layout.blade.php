<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="favicon.ico">

  <title>Cliente VIP Goodyear</title>

  <!-- Bootstrap core CSS -->
	{{HTML::style('dist/css/bootstrap.css')}}
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	{{HTML::style('assets/css/ie10-viewport-bug-workaround.css')}}

  <!-- Custom styles for this template -->
	{{HTML::style('assets/css/main.css?v=6')}}

	{{HTML::script('jquery-1.11.1.min.js')}}

  <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	{{HTML::script('assets/js/ie-emulation-modes-warning.js')}}

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

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
<?php $ruta = Route::getCurrentRoute()->getPath(); $sufijo = ''; ?>

  <?php if($ruta == 'concursa'): ?>
      <div class="background-camera">
      </div>
  <?php else: ?>
      <div class="boton-serviteca"><img src="{{asset('assets/img/red.png')}}" alt="La red de servitecas más grande de Chile" /></div>
      <div class="background-person"></div>
  <?php endif; ?>
  <div class="background-fondo-superior">
    <div class="logo-cliente-vip"></div>
    <!-- Begin page content -->
	@yield('content')

  </div>

  <footer class="footer">
    <div class="menu">
      <a href="{{ URL::to('/') }}"><img class="btn-menu <?php if($ruta == '/' || $ruta == 'distribuidores') {echo 'btn-active'; $sufijo = '-sel';} else $sufijo = ''; ?>" src="{{asset('assets/img/btn-01' . $sufijo . '.png')}}"></a>
      <a href="{{ URL::to('/la-tarjeta-vip') }}"><img class="btn-menu <?php if($ruta == 'la-tarjeta-vip') {echo 'btn-active'; $sufijo = '-sel';} else $sufijo = ''; ?>" src="{{asset('assets/img/btn-02' . $sufijo . '.png')}}"></a>
      <a href="{{ URL::to('/como-funciona') }}"><img class="btn-menu <?php if($ruta == 'como-funciona') {echo 'btn-active'; $sufijo = '-sel';} else $sufijo = ''; ?>" src="{{asset('assets/img/btn-03' . $sufijo . '.png')}}"></a>
      <a href="{{ URL::to('/concursa') }}"><img class="btn-menu <?php if($ruta == 'concursa') {echo 'btn-active'; $sufijo = '-sel';} else $sufijo = ''; ?>" src="{{asset('assets/img/btn-04' . $sufijo . '.png')}}" /></a>
      <a href="{{ URL::to('/serviteca') }}"><img class="btn-menu <?php if($ruta == 'serviteca' || $ruta == 'login' || $ruta == 'compra/revisar' || $ruta == 'venta') {echo 'btn-active'; $sufijo = '-sel';} else $sufijo = ''; ?>" src="{{asset('assets/img/btn-06' . $sufijo . '.png')}}" /></a>
      <a href="{{ URL::to('/contacto') }}"><img class="btn-menu <?php if($ruta == 'contacto') {echo 'btn-active'; $sufijo = '-sel';} else $sufijo = ''; ?>" src="{{asset('assets/img/btn-05' . $sufijo . '.png')}}"></a>
    </div>
  </footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
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
