<?php $__env->startSection('content'); ?>
<div class="row white-bg login-box">
    <!--<div class="col-md-6 log-left">
        <h3>Login</h3>
        <p>Login to post your ad and keep track of it in your account.</p>
        <ul>
            <li><img src="images/d1.png" class="img-fluid d-img" alt="Responsive image"> Start posting your own ads.</li>
            <li><img src="images/d2.png" class="img-fluid d-img" alt="Responsive image"> Mark ads as favorite and view them later.</li>
            <li><img src="images/d3.png" class="img-fluid d-img" alt="Responsive image"> View and manage your ads at your convenience.</li>
        </ul>
    </div>-->
    <div class="col-md-12 log-right">
        <!--<div class="row">
            <button type="button" class="btn btn-primary fb-login-btn com-row">
                <i class="fa fa-facebook-official" aria-hidden="true"></i> Continue with facebook</button>
            <p class="text-or">or</p>
        </div>-->
        <h3 class="text-center mb-4">Login</h3>
        <div class="row">
            <form class="form-horizontal log-form" method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo e(csrf_field()); ?>


                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" aria-describedby="emailHelp" placeholder="Email" required autofocus>

                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Login
                        </button>

                        <p class="text-center">
                            <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                Forgot Your Password?
                            </a>
                        </p>
                    </div>
                </div>
            </form>

            <!--<form class="log-form">
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
            </form>-->
        </div>
        <!--<div class="row"> 
            <button type="button" class="btn btn-dark signup-btn com-row">Log in</button>
            <p class="text-center"><a href=#>Forgot Password?</a></p>
        </div>-->
        <div class="row acc-box">
            <div class="col-md-12">
                <hr>
            </div>
            <p>Don't have an account yet?</p>
            <a href="/register" class="btn btn-light login-btn com-row">Sign up</a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>