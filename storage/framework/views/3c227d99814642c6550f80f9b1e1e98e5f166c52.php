<?php ini_set('max_ecxecution_time', 180); ?>


<?php $__env->startSection('title'); ?> Reset Password | selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row white-bg login-box" style="margin: 7rem;">
    <div class="col-md-12 log-right">        
        <h3 class="text-center mb-4">Reset Password</h3>

        <div class="row">
            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form class="form-horizontal log-form" method="POST" action="<?php echo e(route('password.email')); ?>">
                <?php echo e(csrf_field()); ?>               

                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" aria-describedby="emailHelp" placeholder="Email" required>

                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Send Password Reset Link
                        </button>
                    </div>
                </div>
            </form>
        </div>
    
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>