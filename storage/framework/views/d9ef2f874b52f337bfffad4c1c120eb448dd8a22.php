<?php $__env->startSection('content'); ?>
<div class="container form-pasos">
<h3>Paso 1<br><b>Ingreso de datos</b></h3>
<?php if(isset($error)): ?>
<p class="error"><?php echo e($error); ?></p>
<?php endif; ?>

<form action="<?php echo e(url('login')); ?>" method="post">
	<?php echo e(csrf_field()); ?>

	<div class="row">
	<div class="form-group col-md-12">
		<input class="form-control" type="text" name="email" placeholder="Ingresar usuario" />
	</div>
	<div class="form-group col-md-12">
		<input class="form-control" type="password" name="password" placeholder="Ingresar contraseña" />
	</div>
	<div class="form-group col-md-12">
		<input type="submit" class="btn btn-block btn-primary" value="Ingresar">
	</div>
	</div>
</form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/web/blog/resources/views/login.blade.php ENDPATH**/ ?>