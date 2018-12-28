<?php $__env->startSection('title', 'AdminLTE'); ?>
<?php $__env->startSection('content_header'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.category.list')); ?>">All Categories</a></li>
                <?php if(isset($sub_category_main)): ?>
                    <?php $breadcrumb = \App\Category::setBreadcrumbs($sub_category_main->parent_id); ?>
                    <?php for($i = count($breadcrumb)-1;$i >= 0; $i--): ?>
                        <?php if($i == count($breadcrumb)-1): ?>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.category.list.id',[$breadcrumb[$i][0]])); ?>"><?php echo e($breadcrumb[$i][1]); ?></a> </li>
                        <?php else: ?>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.sub-sub-category.list',[$breadcrumb[$i][0]])); ?>"><?php echo e($breadcrumb[$i][1]); ?></a> </li>
                        <?php endif; ?>

                    <?php endfor; ?>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($sub_category_main->name); ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">Sub Categories</li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
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
                <h4>Add New Sub Catgeory <?php if(isset($sub_category_main)): ?> :: <?php echo e($sub_category_main->name); ?> <?php endif; ?></h4>
            </div>
            <div class="panel-body">
                <form action="<?php echo e(route('administrator.sub-category.add.post')); ?>" method="post">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="hidden" name="parent_id" value="<?php echo e($id); ?>">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Parent Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="parent_category" id="parent_category" required>
                                    <option value="" selected="true" disabled>Select Parent Category</option>
                                    <?php $__currentLoopData = $all_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($id): ?>
                                            <?php if($ac->id == $id): ?>
                                                <option value="<?php echo e($ac->id); ?>" selected="true"><?php echo e($ac->name); ?></option>
                                            <?php endif; ?>
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
                            <label>Sub Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" id="category_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Sub Category Slug : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="slug" id="category_slug" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="category_submit_btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>