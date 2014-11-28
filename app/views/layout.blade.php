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
	<div>
		<a id="avolver" href="{{ URL::to('/') }}"></a>
		<a id="aserviteca" href="{{ URL::to('/serviteca') }}"></a>
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
</body>
</html>
