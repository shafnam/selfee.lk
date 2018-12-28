<?php $__env->startSection('title'); ?> selfee.lk - Electronics, Cars, Property and Jobs in Sri Lanka  <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row topic-bar">
        <h1>Browse by Category</h1>   
    </div>

    <div class="row" style="background: white;">

        <?php $__currentLoopData = $itemServiceCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemServiceCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3 cat-box">
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo e(asset('web-photos/'.$itemServiceCategory->icon)); ?>" class="img-fluid com-img" width="36" alt="<?php echo e($itemServiceCategory->name); ?>">
                    <a href="/ads/category/<?php echo e($itemServiceCategory->slug); ?>"><?php echo e($itemServiceCategory->name); ?></a>
                    <p> (<?php echo e($itemServiceCategory->childrenads->count()); ?>) </p>
                </div> 
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
    </div>
        
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>