<?php $__env->startSection('content'); ?>

<div class="filtro">
	<div><strong>Tarjetas</strong></div>

</div>
	<p><a href="#" onclick="$('#nuevaemp').show()">Nueva empresa</a></p>

	<?php if(count($empresas) == 0): ?>
		<table border="1">
		<tr>
			<th>No hay empresas registradas</th>
		</tr>
		</table>
	<?php else: ?>
		<table border="1">
		<tr>
			<th>Empresa</th>
			<th>Sufijo</th>
			<th>Tarjetas</th>
			<th>Rango</th>
			<th>Códigos</th>
			<th>Opciones</th>
		</tr>
		<?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><a href="#" onclick="$('#r_id_empresa').val(<?php echo e($empresa->id); ?>); $('#renombrar').show()" class="linkoculto"><?php echo e($empresa->nombre); ?></a></td>
			<td><?php echo e($empresa->sufijo); ?></td>
			<td><?php echo e($empresa->tarjetas); ?></td>
			<td><?php echo e($empresa->minimo . ' - ' . $empresa->maximo); ?></td>
			<td>
			<?php if(isset($codempresa[$empresa->id])): ?>
				<?php echo e(implode(', ', $codempresa[$empresa->id])); ?>

			<?php endif; ?>
			</td>
			<td>
				<a href="#" onclick="mostrarCrearTarjetas(<?php echo e($empresa->id); ?>, '<?php echo e($empresa->nombre); ?>')">Crear tarjetas</a> |
				<a href="#" onclick="mostrarCrearCodigo(<?php echo e($empresa->id); ?>, '<?php echo e($empresa->nombre); ?>')">Crear código</a>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</table>
	<?php endif; ?>

	<div id="creartarjetas">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#creartarjetas').hide(); return false;">X</a>
			Crear tarjetas para <span id="empresa-creart"></span>:
			<div class="bloque">
				<form action="<?php echo e(url('admin/tarjetas/crear')); ?>" method="post">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" value="" name="id_empresa" id="t_id_empresa">
					<input type="text" value="" name="cantidad" maxlength="4">
					<input type="submit" value="Crear" name="creartarjetas">
				</form>
			</div>
		</div>
	</div>

	<div id="crearcodigo">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#crearcodigo').hide(); return false;">X</a>
			Crear código personalizado para <span id="empresa-crearc"></span>:
			<div class="bloque">
				<form action="<?php echo e(url('admin/codigo/crear')); ?>" method="post">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" value="" name="id_empresa" id="c_id_empresa">
					<label>Código:</label>
					<input type="text" value="" name="codigo" maxlength="100" style="text-transform:uppercase" required><br>
					<label>Cupo:</label>
					<input type="number" value="" name="cupo"  min="1" max="99999999" required><br>
					<input type="submit" value="Crear" name="crearcodigo">
				</form>
			</div>
		</div>
	</div>

	<div id="nuevaemp">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#nuevaemp').hide(); return false;">X</a>
			Crear empresa:
			<div class="bloque">
				<form action="<?php echo e(url('admin/empresa/crear')); ?>" method="post">
					<?php echo e(csrf_field()); ?>

					<input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Crear" name="nuevaemp">
				</form>
			</div>
		</div>
	</div>

	<div id="renombrar">
		<div class="sombra"></div>
		<div class="popup">
			<a class="cerrar" href="#" onclick="$('#renombrar').hide(); return false;">X</a>
			Cambiar nombre:
			<div class="bloque">
				<form action="<?php echo e(url('admin/empresa/renombrar')); ?>" method="post">
					<?php echo e(csrf_field()); ?>

					<input type="hidden" value="" name="id" id="r_id_empresa">
					<input type="text" value="" id="nombre" name="nombre">
					<input type="submit" value="Guardar" name="guardar">
				</form>
			</div>
		</div>
	</div>

<script>
function mostrarCrearTarjetas(id, nombre) {
	$('#t_id_empresa').val(id);
	$('#empresa-creart').html(nombre);
	$('#creartarjetas').show();
}
function mostrarCrearCodigo(id, nombre) {
	$('#c_id_empresa').val(id);
	$('#empresa-crearc').html(nombre);
	$('#crearcodigo').show();
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/goodyearvip/resources/views/admin/tarjetas.blade.php ENDPATH**/ ?>