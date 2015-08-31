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
	<div id="serviteca">
		<a id="adistribuidores" href="{{ URL::to('/') }}"></a>
	</div>
</div>

<div id="caja">
	{{ HTML::image('images/titulo.png') }}
	
	@yield('content')
</div>

<div id="footer">
	<div>
		<a href="http://goodyear.cl" id="web"></a>
		<a href="{{ URL::to('files/bases.pdf') }}" id="bases" target="_blank"></a>
	</div>
</div>

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
