<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.location.list')); ?>">All Locations</a> </li>
                <li class="breadcrumb-item active" aria-current="page">All Sub Locations</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>All Locations
                    <span class="pull-right" style="margin-top: -5px"><a href="<?php echo e(route('administrator.sub-location.add.get')); ?>" class="btn btn-default">Add New</a></span>
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_sub_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Sub Location Name</th>
                        <th>Sub Location Slug</th>
                        <th>Parent Locations Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $all_sub_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($asl->name); ?></td>
                            <td><?php echo e($asl->slug); ?></td>
                            <td>
                                <?php $parent_location = \App\Location::getParentLocation($asl->parent_id) ?>
                                <span class="badge bg-yellow"><a href="<?php echo e(route('administrator.location.list.id',[$parent_location->id])); ?>" style="color: #ffffff"><?php echo e($parent_location->name); ?></a> </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('administrator.sub-location.edit.get',[$asl->id])); ?>" class="btn btn-primary">Edit</a>
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