<?php $__env->startSection('title'); ?> Login | selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row white-bg login-box">
    
    <div class="col-md-12 log-right">
       
        <h3 class="text-center mb-4">Change password</h3>
        <div class="row">

            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="alert alert-success">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            
            <form class="form-horizontal log-form" method="POST" action="<?php echo e(route('changePassword')); ?>">
                
                <?php echo e(csrf_field()); ?>


                <div class="form-group<?php echo e($errors->has('current-password') ? ' has-error' : ''); ?>">
                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control" name="current-password" placeholder="Current password" required>
                        <?php if($errors->has('current-password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('current-password')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group<?php echo e($errors->has('new-password') ? ' has-error' : ''); ?>">
                    <div class="col-md-6">
                        <input id="new-password" type="password" class="form-control" name="new-password"  placeholder="New password" required>

                        <?php if($errors->has('new-password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('new-password')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" placeholder="Confirm password" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Change Password
                        </button>
                    </div>
                </div>

            </form>           
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>