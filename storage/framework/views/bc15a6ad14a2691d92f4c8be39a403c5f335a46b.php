

<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <?php if(isset($category)): ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.category.list')); ?>">All Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($category->name); ?></li>
                <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                    <?php if(isset($category)): ?>
                        Category :: <?php echo e($category->name); ?>

                    <?php else: ?>
                        All Categories
                        <span class="pull-right" style="margin-top: -5px"><a href="<?php echo e(route('administrator.category.add.get')); ?>" class="btn btn-default">Add New</a></span>
                    <?php endif; ?>

                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_category_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Slug</th>
                        <th>Sub Categories</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $all_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($ac->name); ?></td>
                            <td><?php echo e($ac->slug); ?></td>
                            <td>
                                <?php $sub_category = \App\Category::getSubCategories($ac->id);?>
                                <?php $__currentLoopData = $sub_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-yellow"><a href="<?php echo e(route('administrator.sub-sub-category.list',[$sc->id])); ?>" style="color: #ffffff"><?php echo e($sc->name); ?></a></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('administrator.category.edit.get',[$ac->id])); ?>" class="btn btn-primary">Edit</a>
                                <a href="<?php echo e(route('administrator.sub-sub-category.add.get',[$ac->id])); ?>" class="btn btn-success">Add New Sub Category</a>
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