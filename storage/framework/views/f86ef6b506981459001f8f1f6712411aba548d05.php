<?php $__env->startSection('title'); ?> Reset Password | selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row white-bg login-box" style="margin: 7rem;">     
        
    <div class="col-md-12 log-right">        
        <h3 class="text-center mb-4">Reset Password</h3>

        <div class="row">    

            <form class="form-horizontal log-form" method="POST" action="<?php echo e(route('password.request')); ?>">
                <?php echo e(csrf_field()); ?>


                <input type="hidden" name="token" value="<?php echo e($token); ?>">

                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(isset($email) ? $email : old('email')); ?>" placeholder="E-Mail Address" required autofocus>

                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>

                        <?php if($errors->has('password_confirmation')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Reset Password
                        </button>
                    </div>
                </div>
            </form>            

        </div>
    
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>