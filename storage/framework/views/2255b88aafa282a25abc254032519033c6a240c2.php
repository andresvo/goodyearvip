<?php $__env->startSection('content'); ?>


	<div class="filtro">
		<div><strong>Ventas</strong></div>
		<form action="<?php echo e(url('admin')); ?>" method="post">
		<?php echo e(csrf_field()); ?>

		<select name="id_empresa" id="id_empresa">
			<?php $__currentLoopData = $opcionesemp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($i == $id_empresa): ?>
				<option value="<?php echo e($i); ?>" selected><?php echo e($row); ?></option>
				<?php else: ?>
				<option value="<?php echo e($i); ?>"><?php echo e($row); ?></option>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select> &nbsp;
			<select name="id_usuario" id="id_usuario">
			<?php $__currentLoopData = $opciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if($i == $id_usuario): ?>
				<option value="<?php echo e($i); ?>" selected><?php echo e($row); ?></option>
				<?php else: ?>
				<option value="<?php echo e($i); ?>"><?php echo e($row); ?></option>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
			<input type="submit" value="Filtrar">
		</form>
	</div>

	<?php if($id_empresa != null): ?>
	<p><a href="<?php echo e(URL::to('/excel') . '/' . $id_empresa); ?>">Descargar Excel</a></p>
	<?php else: ?>
	<p><a href="<?php echo e(URL::to('/excel')); ?>">Descargar Excel</a></p>
	<?php endif; ?>

	<?php if(count($compras) == 0): ?>
		<table border="1">
		<tr>
			<th>No hay ventas registradas por <?php echo e($opciones[$id_usuario]); ?></th>
		</tr>
		</table>
	<?php else: ?>
		<table border="1">
		<tr>
			<th>Usuario</th>
			<th>Diseño</th>
			<th>Medida</th>
			<th>Cantidad</th>
			<th>Tarjeta</th>
			<th>Fecha creación</th>
			<th>Opciones</th>
		</tr>
		<?php $__currentLoopData = $compras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($compra->email); ?></td>
			<td><?php echo e($compra->pnombre); ?></td>
			<td><?php echo e($compra->mnombre); ?></td>
			<td><?php echo e($compra->cantidad); ?></td>
			<td><?php echo e($compra->codigo); ?></td>
			<td><?php echo e($compra->created_at); ?></td>
			<td><a href="<?php echo e(URL::to('/compra/anular') . '/' . $compra->id); ?>" onclick="return confirm('¿Desea anular esta venta? La tarjeta recuperará su cupo anterior a la venta.')">Anular</a></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/goodyearvip/resources/views/admin/admin.blade.php ENDPATH**/ ?>