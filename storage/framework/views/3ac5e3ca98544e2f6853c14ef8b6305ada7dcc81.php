<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <!-- Font Awesome-->
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome.css')); ?>">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="<?php echo e(asset('css/business-frontpage.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/lightslider.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/side-bar.css')); ?>">
</head>

<body>
    <div id="app">
        <?php echo $__env->make('inc.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <!-- Show only on Home page -->
        <?php if(Request::is('/')): ?>
            <?php echo $__env->make('inc.home-banner', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
        <!-- /.Show only on Home page -->
        <?php echo $__env->yieldContent('breadcrumbs'); ?>
        <div class="container-fluid b-section inner-page">
            <div class="container" <?php if(Request::is('/')): ?> style="margin-top: 60px;"<?php endif; ?>>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
    <?php echo $__env->make('inc.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
</body>
</html>
