<?php $__env->startSection('content'); ?>

<div class="container distribuidores">
	<?php $__currentLoopData = $distribuidores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $dist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php
	if($dist['ubicacion'] != '') $address = $dist['ubicacion'];
	else $address = str_replace('#', '', $dist['direccion']) . ', ' . $dist['comuna']; ?>
		<div>

			<table><tr><td>
			<strong><?php echo e($dist->nombre); ?></strong><br>
			<?php echo e($dist->direccion); ?><br>
			<strong>Teléfono</strong><br>
			<?php echo e($dist->telefono); ?><br>
			<strong>Web</strong> <?php echo e($dist->web); ?>

			</td></tr></table>

			<div class="mapa" id="map-canvas<?php echo e($dist->id); ?>"></div>

			<p>
				<a href="http://maps.google.com/maps?&z=10&q=<?php echo $address ?>" target="_blank">Ver mapa ampliado</a>
			</p>

			<script>
			var geocoder, map<?php echo e($i); ?>;

			function codeAddress<?php echo e($i); ?>(address) {
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
				        map<?php echo e($i); ?> = new google.maps.Map(document.getElementById("map-canvas<?php echo e($dist->id); ?>"), myOptions);

				        map<?php echo e($i); ?>.mapTypes.set('map_style', styledMap);
				        map<?php echo e($i); ?>.setMapTypeId('map_style');

				        var marker = new google.maps.Marker({
				            map: map<?php echo e($i); ?>,
				            icon: 'http://clientevipgoodyear.cl/images/marker.png',
				            position: results[0].geometry.location
				        });
				    }
				});
			}
			</script>
		</div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
function initialize() {
	<?php $__currentLoopData = $distribuidores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $dist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
		if($dist['ubicacion'] != '') $address = $dist['ubicacion'];
		else $address = $dist['direccion'] . ', ' . $dist['comuna'];?>
		codeAddress<?php echo e($i); ?>("<?php echo e($address); ?>");
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/blog/resources/views/distribuidor.blade.php ENDPATH**/ ?>