<?php $__env->startSection('title', 'AdminLTE'); ?>
<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.location.list')); ?>">All Locations</a> </li>
                <?php if(isset($location)): ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.location.list.id',[$location->id])); ?>"><?php echo e($location->name); ?></a> </li>
                <?php else: ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.sub-location.list')); ?>">Sub Location</a> </li>
                <?php endif; ?>

                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <?php if(session()->has('success_messge')): ?>
            <div class="alert alert-success">
                <ul>
                    <li><?php echo e(session()->get('success_messge')); ?></li>
                </ul>
            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Add New Sub Location <?php if(isset($location)): ?> :: <?php echo e($location->name); ?><?php endif; ?></h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo e(route('administrator.sub-location.add.post')); ?>" method="post">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Parent Location Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                               <select class="form-control" name="parent_location" id="parent_location" required>
                                   <option value="" selected="true" disabled>Select Parent Location</option>
                                   <?php $__currentLoopData = $all_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $al): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if(isset($location)): ?>
                                           <?php if($al->id == $location->id): ?>
                                               <option value="<?php echo e($al->id); ?>" selected="true"><?php echo e($al->name); ?></option>
                                           <?php endif; ?>
                                       <?php else: ?>
                                           <option value="<?php echo e($al->id); ?>"><?php echo e($al->name); ?></option>
                                       <?php endif; ?>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Sub Location Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" id="location_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Sub Location Slug : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="slug" id="location_slug" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="location_submit_btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>