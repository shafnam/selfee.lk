<?php $__env->startSection('title', 'AdminLTE'); ?>

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
                    <li class="breadcrumb-item active" aria-current="page">All Sub Categories</li>
                <?php endif; ?>

            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><?php if(isset($sub_category_main)): ?> Sub Category :: <?php echo e($sub_category_main->name); ?>

                        <span class="pull-right" style="margin-top: -5px">
                            <a href="<?php echo e(route('administrator.sub-sub-category.add.get',[$sub_category_main->id])); ?>" class="btn btn-default">Add New</a>
                        </span>
                    <?php else: ?>
                        All Sub Categories
                        <span class="pull-right" style="margin-top: -5px">
                            <a href="<?php echo e(route('administrator.sub-category.add.get')); ?>" class="btn btn-default">Add New</a>
                        </span>
                    <?php endif; ?>

                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_sub_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Sub Category Name</th>
                        <th>Sub Category Slug</th>
                        <th>Parent Category Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $all_sub_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($asc->name); ?></td>
                            <td><?php echo e($asc->slug); ?></td>
                            <td>
                                <?php $parent_category = \App\Category::getParentCategory($asc->parent_id) ?>
                                <span class="badge bg-yellow"><a href="<?php echo e(route('administrator.category.list.id',[$parent_category->id])); ?>" style="color: #ffffff"><?php echo e($parent_category->name); ?></a> </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('administrator.sub-category.edit.get',[$asc->id])); ?>" class="btn btn-primary">Edit</a>
                                <a href="<?php echo e(route('administrator.sub-sub-category.add.get',[$asc->id])); ?>" class="btn btn-success">Add New Sub Category</a>
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