<?php $__env->startSection('title'); ?> Classifieds on selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Page Content -->
    
            <?php echo $__env->make('inc.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->make('inc.search-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="row white-bg">
                
                <?php echo $__env->make('inc.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="col-md-7 s-result">
                
                    <!--  breadcrumbs-->
                    <div class="row">
                        <div class="col-md-12 res-top">
                            <p>
                                <a href="<?php echo e(url('/')); ?>">Home</a> 
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="<?php echo e(url('ads')); ?>">All ads</a>
                                <?php if(isset($locationParentName)): ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="<?php echo e(url('ads/location/'.$location_parent_slug)); ?>"><?php echo e($locationParentName); ?></a> <?php endif; ?>
                                <?php if(isset($locationName)): ?> <?php if(isset($categoryName)): ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="<?php echo e(url('ads/location/'.$location_slug)); ?>"><?php echo e($locationName); ?> </a> <?php else: ?> <b><?php echo e($locationName); ?></b> <?php endif; ?> <?php endif; ?>
                                <?php if(isset($categoryParentName)): ?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="<?php echo e(url('ads/category/'.$category_parent_slug)); ?>"><?php echo e($categoryParentName); ?></a> <?php endif; ?>
                                <?php if(isset($categoryName)): ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i><b><?php echo e($categoryName); ?></b><?php endif; ?>
                            </p>
                            <p><b>Showing: <?php echo e($ads->firstItem()); ?> - <?php echo e($ads->lastItem()); ?> of <?php echo e($ads->total()); ?> ads</b></p>
                        </div>
                    </div>
                    <!-- /.breadcrumbs-->
                    
                    <!-- Ads Display Starts Here-->
                    <?php if(count($ads) > 0): ?>
                        <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $path = 'uploads'; $string = "\\"; ?>
                            <div class="row add-box">
                                <div class="col-md-4">
                                    <img src="<?php echo e(asset('ad-photos/'.$ad->ad_photos->first()->title)); ?>" class="img-fluid" alt="Responsive image">
                                </div>
                                <div class="col-md-8">
                                    <a href="<?php echo e(url('ads/'.$ad->slug )); ?>"><?php echo e($ad->title); ?></a>
                                    <p class="add-time"><i class="fa fa-clock-o" aria-hidden="true"></i> 
                                        <?php echo e(date('d M g:i a', strtotime($ad->created_at))); ?>

                                    </p>
                                    <p class="add-loca"><i class="fa fa-map-marker" aria-hidden="true"></i> 
                                        <?php echo e($ad->locations->name); ?>, <?php echo e($ad->categories->name); ?>

                                    </p>
                                    <?php if(isset($ad->price)): ?>
                                    <p class="add-price">Rs <?php echo e($ad->price); ?></p>
                                    <?php endif; ?>
                                    <p class="add-details">type: <?php echo e($ad->type_id); ?></p>
                                    <?php if(isset($ad->electronics_ads->condition)): ?>
                                    <p class="add-details">cond:  <?php echo e($ad->electronics_ads->condition); ?></p>
                                    <?php endif; ?>
                                    <?php if(isset($ad->electronics_ads->brand)): ?>
                                    <p class="add-details">brand: <?php echo e($ad->electronics_ads->brand); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-md-4 mt-3 mb-3">
                                <?php echo e($ads->links()); ?>

                            </div>
                        </div>
                        <!-- Pagination -->
                        

                    <?php else: ?>
                        <p>No Ads were Found</p>
                    <?php endif; ?>
                </div>

                <div class="col-md-2 s-adz">
                    
                </div>

            </div>
        
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>