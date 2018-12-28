<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <?php if(isset($brand)): ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.brands.list',[$brand->id])); ?>"><?php echo e($brand->name); ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">Brands</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                <?php endif; ?>
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
                <h4>Edit - Brand </h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo e(route('administrator.brands.edit.post',[$brand->id])); ?>" method="post">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" id="brand_id" name="brand_id" value="<?php echo e($brand->id); ?>">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="category" id="category" required>
                                    <option value="" selected="true" disabled>Select Category</option>
                                    <?php $__currentLoopData = $all_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($ac->id == $brand->category_id): ?>
                                            <option value="<?php echo e($ac->id); ?>" selected="true"><?php echo e($ac->name); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($ac->id); ?>"><?php echo e($ac->name); ?></option>
                                        <?php endif; ?>
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
                                <input name="name" id="brand_name" class="form-control" required value="<?php echo e($brand->name); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="brand_submit_btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>