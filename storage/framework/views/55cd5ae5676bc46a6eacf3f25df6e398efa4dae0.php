

<?php $__env->startSection('title'); ?> Choose Category <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <!-- Page Content -->
    <div class="row white-bg add-cat">
        
            <div class="col-lg-12 add-cat-topic">
            <?php if($ad_type == 'for-sale'){ ?>
                    <h3>Sell an item or service</h3>
            <?php } else if($ad_type == 'for-rent'){ ?>
                    <h3>Offer a property for rent</h3>
            <?php } else if($ad_type == 'to-rent'){ ?>
                    <h3>Look for property to rent</h3>
            <?php } else if($ad_type == 'to-buy'){ ?>
                    <h3>Look for something to buy</h3>
            <?php } ?>
                    <hr>
            </div>

        <div class="col-md-12 td-box2">
            <div class="row">
                    <div class="col-lg-12 col-md-12">
                        
                        <div class="row">
                            
                            <div class="col-lg-4 col-md-6">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    
                                    <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Select a category</h4>
                                    
                                    <?php $__currentLoopData = $allSubCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $has_children = \App\Category::hasChildCategory($subCats->id);
                                        if($has_children) {
                                    ?>
                                        <a class="nav-link" id="<?php echo e($subCats->slug); ?>-tab" data-toggle="pill" href="#<?php echo e($subCats->slug); ?>" role="tab" aria-controls="<?php echo e($subCats->slug); ?>" aria-selected="true">
                                            <?php if(isset($subCats->icon)): ?>
                                            <img src="<?php echo e(asset('web-photos/'.$subCats->icon)); ?>" class="img-fluid" width="18" alt="Responsive image">
                                            <?php endif; ?>
                                            <?php echo e($subCats->name); ?>

                                            <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    <?php } else { ?>
                                        <a class="nav-link" href="<?php echo e(url('ads/post-ad/'.$ad_type.'/'.$type.'/'.$subCats->parent_id.'/'.$subCats->slug )); ?>">
                                            <?php if(isset($subCats->icon)): ?>
                                            <img src="<?php echo e(asset('web-photos/'.$subCats->icon)); ?>" class="img-fluid" width="18" alt="Responsive image">
                                            <?php endif; ?>
                                            <?php echo e($subCats->name); ?>

                                            <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    <?php } ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </div>
                            </div>
                                
                            <div class="col-lg-5 col-md-6">
                                <div class="tab-content" id="v-pills-tabContent">
                                    
                                        <?php $__currentLoopData = $allSubCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                        <div class="tab-pane fade" id="<?php echo e($subCats->slug); ?>" role="tabpanel" aria-labelledby="<?php echo e($subCats->slug); ?>-tab">
                                            <h4>Select a sub category...</h4>
                                            <ul>
                                                <?php $__currentLoopData = $subCats->subCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $firstNestedSub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($firstNestedSub->name != 'Portions & Rooms' && $firstNestedSub->name != 'Holiday & Short-Term Rental'){ ?>
                                                    <li><a href="<?php echo e(url('ads/post-ad/'.$ad_type.'/'.$type.'/'.$firstNestedSub->parent_id.'/'.$firstNestedSub->slug )); ?>"><?php echo e($firstNestedSub->name); ?><span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                                <?php } ?>
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
        <div class="col-md-12 td-box">
            <p><i class="fa fa-caret-right" aria-hidden="true"></i> Location</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i> Details</p>
        </div>
    </div>
    
    <!-- Page Content -->
          
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>