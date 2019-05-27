<?php $__env->startSection('content'); ?>

<div class="filtro">
	<div><strong>Concurso</strong></div>

</div>
	<?php if(count($concursantes) == 0): ?>
		<table border="1">
		<tr>
			<th>No hay concursantes registrados</th>
		</tr>
		</table>
	<?php else: ?>
		<table border="1">
		<tr>
			<th>Fecha</th>
			<th>Nombre</th>
			<th>Email</th>
			<th>Marca</th>
			<th>Modelo</th>
			<th>Opciones</th>
		</tr>
		<?php $__currentLoopData = $concursantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($c->created_at); ?></td>
			<td><?php echo e($c->nombre); ?></td>
			<td><?php echo e($c->email); ?></td>
			<td><?php echo e($c->marca); ?></td>
			<td><?php echo e($c->modelo); ?></td>
			<td><a href="<?php echo e(URL::to('admin/concursante/eliminar/' . $c->id)); ?>" onclick="return confirm('¿Seguro desea eliminar?')">eliminar</a></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/goodyearvip/resources/views/admin/concurso.blade.php ENDPATH**/ ?>