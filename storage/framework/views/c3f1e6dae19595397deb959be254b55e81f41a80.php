<!--<div class="container-fluid home-top">-->
    <div class="container">
        <div class="row">
            
            <div class="col-md-12 c-left pt-5">
                
                <h1>Welcome to Selfee.lk - the largest marketplace in Sri Lanka!</h1>
                <p>Buy and sell everything from used cars to mobile phones and computers, or search for property, jobs and more in Sri Lanka!</p>

                <h4>Browse our top categories:</h4>
                <div class="row top-cat-bar">
                    
                    <?php $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-2">
                        <div class="card">
                            <img src="/storage/images/<?php echo e($topCategory->icon); ?>" class="img-fluid com-img" width="36" alt="<?php echo e($topCategory->name); ?>">
                            <a href="<?php echo e(url('ads/category/'.$topCategory->slug)); ?>"><?php echo e($topCategory->name); ?></a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

            </div>

            <div class="col-md-12 top-main-box pb-5">
                <div class="row topic-bar">
                    <h1>Browse by Location</h1> 
                </div>
                <div class="row location-box">
                    <?php $__currentLoopData = $parentLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3">
                        <div class="card box-one">
                            <div class="card-body">
                                <ul>
                                    <li><a href="<?php echo e(url('ads/location/'.$parentLocation->slug )); ?>"><i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo e($parentLocation->name); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

    </div>
<!--</div>  -->