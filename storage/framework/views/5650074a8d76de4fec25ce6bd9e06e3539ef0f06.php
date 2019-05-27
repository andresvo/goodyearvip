<?php $__env->startSection('content'); ?>

<div class="container form-pasos">
	<?php if(isset($ingresada)): ?>
		<h3>Listo</h3>
		<p class="error">
			<a href="<?php echo e(URL::to('/serviteca')); ?>" class="x"></a>
			<span>La venta ha sido registrada</span>
		</p>
			<p><a href="<?php echo e(URL::to('/logout')); ?>" class="fuera">Cerrar sesión</a></p>

	<?php else: ?>
		<h3>Paso 4<br><b>Confirmación</b></h3>
		<form action="<?php echo e(url('compra/crear')); ?>" method="post">
		<?php echo e(csrf_field()); ?>


		<div class="row">
		<div class="form-group col-md-12">
			<a href="<?php echo e(URL::to('/serviteca')); ?>" class="x" onclick="$('#volver').submit();return false"></a>
			<div id="revisar">
			<table class="revisar">
				<tr>
				<td>Diseño : </td><td style="text-align:left"><?php echo e($producto->nombre); ?></td>
				</tr>
				<tr>
				<td>Medida : </td><td style="text-align:left"><?php echo e($medida->nombre); ?></td>
				</tr>
				<tr>
				<td>Cantidad : </td><td style="text-align:left"><?php echo e($cantidad); ?></td>
				</tr>
				<tr>
				<td>Boleta : </td><td style="text-align:left"><?php echo e($boleta); ?></td>
				</tr>
				<tr>
				<td>Factura : </td><td style="text-align:left"><?php echo e($factura); ?></td>
				</tr>
				<tr>
				<td>Precio unitario : </td><td style="text-align:left"><?php echo e($precio); ?></td>
				</tr>
			</table>
			</div>
		</div>
		</div>


			<input type="hidden" name="id_tarjeta" value="<?php echo e($id_tarjeta); ?>" />
			<input type="hidden" name="producto" value="<?php echo e($producto->id); ?>" />
			<input type="hidden" name="medida" value="<?php echo e($medida->id); ?>" />
			<input type="hidden" name="cantidad" value="<?php echo e($cantidad); ?>" />
			<input type="hidden" name="boleta" value="<?php echo e($boleta); ?>" />
			<input type="hidden" name="factura" value="<?php echo e($factura); ?>" />
			<input type="hidden" name="precio" value="<?php echo e($precio); ?>" />
			<div class="form-group col-md-12">
				<input type="submit" class="btn btn-block btn-primary" value="Ingresar" />
			</div>
		</form>

		<form action="<?php echo e(url('serviteca')); ?>" id="volver">
			<?php echo e(csrf_field()); ?>

			<input type="hidden" name="codigo" value="<?php echo e($codigo); ?>" />
		</form>

	<?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/blog/resources/views/venta.blade.php ENDPATH**/ ?>