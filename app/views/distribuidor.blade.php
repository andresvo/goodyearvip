@extends('layout')

@section('content')

<div class="container distribuidores">
	@foreach($distribuidores as $i => $dist)
		<div>
			<table><tr><td>
			<strong>{{ $dist->nombre }}</strong><br>
			{{ $dist->direccion }}<br>
			<strong>Teléfono</strong><br>
			{{ $dist->telefono }}<br>
			<strong>Web</strong> {{ $dist->web }}
			</td></tr></table>

			<div class="mapa" id="map-canvas{{ $dist->id }}"></div>

			<script>
			var geocoder, map{{ $i }};

			function codeAddress{{ $i }}(address) {
				geocoder = new google.maps.Geocoder();
				geocoder.geocode({
				    'address': address
				}, function(results, status) {
				    var styledMap = new google.maps.StyledMapType(styles,
				        {name: "Styled Map"});

				    if (status == google.maps.GeocoderStatus.OK) {
				        var myOptions = {
				            zoom: 16,
				            center: results[0].geometry.location,
				            mapTypeControlOptions: {
				              mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				            }
				        }
				        map{{ $i }} = new google.maps.Map(document.getElementById("map-canvas{{ $dist->id }}"), myOptions);

				        map{{ $i }}.mapTypes.set('map_style', styledMap);
				        map{{ $i }}.setMapTypeId('map_style');

				        var marker = new google.maps.Marker({
				            map: map{{ $i }},
				            icon: 'http://dev.crio.cl/goodyearvip/public/images/marker.png',
				            position: results[0].geometry.location
				        });
				    }
				});
			}
			</script>
		</div>
	@endforeach
</div>

<script>
function initialize() {
	@foreach($distribuidores as $i => $dist)
		<?php
		if($dist['ubicacion'] != '') $address = $dist['ubicacion'];
		else $address = $dist['direccion'] . ', ' . $dist['comuna'];?>
		codeAddress{{ $i }}("{{ $address }}");
	@endforeach
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

@stop
