<?php $__env->startSection('title', 'AdminLTE'); ?>
<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.brands.list')); ?>">All Brands</a></li>
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
                <h4>Add - New Brand</h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo e(route('administrator.brands.add.post')); ?>" method="post">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="category_id" value="<?php echo e($id); ?>">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="category" id="category" required>
                                    <option value="" selected="true" disabled>Select Category</option>
                                    <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <option value="<?php echo e($ac->id); ?>"><?php echo e($ac->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Brand Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" id="brand_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="brand_submit_btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>