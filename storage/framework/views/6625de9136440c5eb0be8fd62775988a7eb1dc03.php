<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <?php if(isset($brand)): ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.brands.list')); ?>">All Brands</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($brand->name); ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">All Brands</li>
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
                <h4>
                    <?php if(isset($brand)): ?>
                        Brand :: <?php echo e($brand->name); ?>

                    <?php else: ?>
                        All Brands
                        <span class="pull-right" style="margin-top: -5px"><a href="<?php echo e(route('administrator.brands.add.get')); ?>" class="btn btn-default">Add New</a></span>
                    <?php endif; ?>

                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_category_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $all_brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($ab->name); ?></td>
                            <td>
                                <?php echo e($ab->categories->name); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('administrator.brands.edit.get',[$ab->id])); ?>" class="btn btn-primary" style="float: left; margin-right: 10px;">Edit</a>
                                <!--Delete Function-->
                                <!--<form action="<?php echo e(route('administrator.brands.destroy', $ab->id)); ?>" method="POST" onsubmit="return confirm('Do you really want to delete?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>-->
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>