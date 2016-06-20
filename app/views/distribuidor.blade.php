@extends('layout')

@section('content')

<div class="container distribuidores">
	@foreach($distribuidores as $dist)
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
			var geocoder, map;

			function codeAddress(address) {
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
			        map = new google.maps.Map(document.getElementById("map-canvas{{ $dist->id }}"), myOptions);

			        map.mapTypes.set('map_style', styledMap);
			        map.setMapTypeId('map_style');

			        var marker = new google.maps.Marker({
			            map: map,
			            icon: 'http://localhost/web/cachana/public/images/marker.png',
			            position: results[0].geometry.location
			        });
			    }
			});
			}
			    function initialize() {
			        codeAddress('Avda. Picarte # 1645, Valdivia');
			    }

			    google.maps.event.addDomListener(window, 'load', initialize);
			</script>
		</div>
	@endforeach
</div>

@stop
