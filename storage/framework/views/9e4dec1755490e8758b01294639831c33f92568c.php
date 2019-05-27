<?php $__env->startSection('content'); ?>

<div class="filtro">
	<div><strong>Productos</strong></div>

</div>
	<p>
		<a href="#" onclick="$('#nuevoprod').show()">Nuevo producto</a>
	</p>

	<?php if(count($productos) == 0): ?>
		<table border="1">
		<tr>
			<th>No hay productos registrados</th>
		</tr>
		</table>
	<?php else: ?>
		<table border="1">
		<tr>
			<th>Diseño</th>
			<th>Activo</th>
			<th>Opciones</th>
		</tr>
		<?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><a href="#" onclick="$('#r_id_empresa').val(<?php echo e($producto->id); ?>); $('#renombrar').show()" class="linkoculto"><?php echo e($producto->nombre); ?></a></td>
			<td><?php echo e(intval($producto->activo)); ?></td>
			<td>
				<a href="<?php echo e(URL::to('admin/medidas/'.$producto->id)); ?>">Ver medidas</a> |
				<a href="#" onclick="editar(<?php echo e($producto->id); ?>)">Editar</a> |
				<a href="<?php echo e(URL::to('admin/producto/eliminar/'.$producto->id)); ?>" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar</a>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	<?php endif; ?>

	<div id="nuevoprod" class="oculto">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#nuevoprod').hide(); return false;">X</a>
			Crear producto:
			<div class="bloque">
				<form action="<?php echo e(url('admin/producto/crear')); ?>" method="post">
					<?php echo e(csrf_field()); ?>

					Diseño: <input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Crear" name="nuevoprod">
				</form>
			</div>
		</div>
	</div>

	<div id="renombrar" class="oculto">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#renombrar').hide(); return false;">X</a>
			Cambiar nombre:
			<div class="bloque">
				<form action="<?php echo e(url('admin/producto/editar')); ?>" method="post">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" value="" name="id" id="r_id_producto">
					<input type="text" value="" id="r_nombre" name="nombre" size="55"><br>
					<p><input type="checkbox" name="activo" id="r_activo" value="1"> Activo </p>
					<input type="submit" value="Guardar" name="guardar">
				</form>
			</div>
		</div>
	</div>

<script>
productos = <?php echo e($json_productos); ?>;

function editar(id_producto) {
	$('#r_id_producto').val(id_producto);
	$('#r_nombre').val(productos[id_producto].nombre);
	if(productos[id_producto].activo == 1) $('#r_activo').attr('checked', true);
	else $('#r_activo').attr('checked', false);
	$('#renombrar').show();
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/goodyearvip/resources/views/admin/productos.blade.php ENDPATH**/ ?>