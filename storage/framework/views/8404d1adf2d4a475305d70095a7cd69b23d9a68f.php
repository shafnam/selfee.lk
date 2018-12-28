<?php $__env->startSection('title'); ?> Choose Nearest Area <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <!-- Page Content -->
    <div class="row white-bg add-cat">
        
        <div class="col-md-12 add-cat-topic">
            <h3>Where are you located?</h3>
            <hr>
        </div>

        <div class="col-lg-7 col-md-10 cat-sec">
            <p>
                <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                Category: <?php echo e($getCatParentDetails->name); ?> <!--get db values -->
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

            <?php if(strpos($getCatDetails->name , '_fs') !== false) { 
                $getCatDetails->name  = str_replace('_fs', '', $getCatDetails->name);
            ?>
                <?php echo e($getCatDetails->name); ?>

            <?php } else { ?>
                <?php echo e($getCatDetails->name); ?>

            <?php } ?>

                <span class="r-change">
                    <a href="<?php echo e(url('ads/post-ad/'.$ad_type.'/'.$type )); ?>">Change</a>
                </span>

            </p>
            <hr>
        </div>
    

        <div class="col-md-12 td-box2">
            <div class="row">
                    <div class="col-lg-12 col-md-12">
                        
                        <div class="row">
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Select a Location</h4>
                                    <p>Districts</p>
                                    <?php $__currentLoopData = $allSubLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subLoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a class="nav-link" id="<?php echo e($subLoc->slug); ?>-tab" data-toggle="pill" href="#<?php echo e($subLoc->slug); ?>" role="tab" aria-controls="<?php echo e($subLoc->slug); ?>" aria-selected="true">
                                            <?php echo e($subLoc->name); ?>

                                            <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                                
                            <div class="col-lg-4 col-md-6">
                                <div class="tab-content" id="v-pills-tabContent">
                                    
                                    <?php $__currentLoopData = $allSubLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subLoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                    <div class="tab-pane fade" id="<?php echo e($subLoc->slug); ?>" role="tabpanel" aria-labelledby="<?php echo e($subLoc->slug); ?>-tab">
                                        <h4>Select a local area within <?php echo e($subLoc->location_name); ?></h4>
                                        <p>Popular areas</p>
                                        <ul>
                                            <?php $__currentLoopData = $subLoc->subLocation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $firstNestedSub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a href="<?php echo e(url('ads/post-ad/'.$ad_type.'/'.$type.'/'.$getCatParentDetails->id.'/'.$getCatDetails->slug.'/'.$firstNestedSub->parent_id.'/'.$firstNestedSub->slug )); ?>"><?php echo e($firstNestedSub->name); ?> <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                        </div>
                        
                    </div>
            </div>
        </div>

        <div class="col-md-12 ml-3 mt-3">
            <p><!--<i class="fa fa-caret-right" aria-hidden="true"></i>-->3. Details</p>
        </div>
    </div>
    
    <!-- Page Content -->
          
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>