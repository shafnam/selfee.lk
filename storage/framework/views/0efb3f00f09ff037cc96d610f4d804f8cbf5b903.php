<?php $__env->startSection('title'); ?> Account Settings <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?> 

<?php echo $__env->make('inc.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container">
    <div class="row white-bg rules-box myaccount-page">

        <div class="col-md-12 help-box2">
            <div class="row">
                <?php echo $__env->make('inc.user-profile-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-lg-9 col-md-8 help-right">
                    <div class="tab-content">
                        <div class="tab-pane fade show active about-box set-box">
                            <h3>Settings</h3>
                            <hr>
                            <h4>Change details</h4>
                            <p><span class="set-email-txt">Email:</span>  <?php echo e($customer->email); ?></p>

                            <div class="update-box">
                                <?php echo Form::open(['action' => ['CustomersController@update', $customer->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']); ?>

                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="title">Name</label> 
                                        <input type="text" name="customer_name" value="<?php echo e($customer->name); ?>" id="customer_name" class="form-control">
                                        <span class="text-danger"><?php echo e($errors->first('customer_name')); ?></span>
                                    </div>
                                    <!-- Location -->
                                    <div class="form-group">
                                        <label for="Location">Location</label>
                                        <select name="customer_locations" class="form-control" id="customer_locations">
                                            <option>-- Location --</option>
                                            <?php $locations = \App\Location::getAllLocations(); ?>
                                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($location->name); ?>" <?php echo e($location->name == $customer->location ? 'selected' : ''); ?> >
                                                <?php echo e($location->name); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="Location">Sub Location</label>
                                        <select name="customer_sub_locations" class="form-control">
                                        <?php if(isset($customer->location)){ 
                                            $sub_locations = \App\Location::getSubLocationByParentLocation($customer->location);
                                            foreach($sub_locations as $sub_location){
                                        ?>
                                            <option value="<?php echo e($sub_location->name); ?>" <?php echo e($sub_location->name == $customer->sub_location ? 'selected' : ''); ?> >
                                                <?php echo e($sub_location->name); ?>

                                            </option>
                                        <?php }  } else { ?> 
                                            <option>-- SubLocation --</option>  
                                        <?php } ?>       
                                        </select>                                        
                                    </div>
                                    <?php echo e(form::hidden('_method', 'PUT')); ?>

                                    <?php echo e(form::submit('Update Details', ['class' => 'btn btn-secondary'])); ?>

                                
                                <?php echo Form::close(); ?>


                            </div>

                            <!--<h4>Change password</h4>-->

                            <div class="update-box">
                                
                            </div>

                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>