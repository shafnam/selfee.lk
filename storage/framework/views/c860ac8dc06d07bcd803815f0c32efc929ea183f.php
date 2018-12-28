<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <?php if(!isset($location)): ?>
                    <li class="breadcrumb-item active" aria-current="page">All Locations</li>
                <?php else: ?>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.location.list')); ?>">All Locations</a> </li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo e($location->name); ?></li>
                <?php endif; ?>

            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                    <?php if(!isset($location)): ?>
                        All Locations
                        <span class="pull-right" style="margin-top: -5px">
                            <a href="<?php echo e(route('administrator.location.add.get')); ?>" class="btn btn-default">Add New</a>
                        </span>
                    <?php else: ?>
                        All Locations :: <?php echo e($location->name); ?>

                        <span class="pull-right" style="margin-top: -5px">
                            <a href="<?php echo e(route('administrator.sub-location.add.get.id',[$location->id])); ?>" class="btn btn-default">Add New</a>
                        </span>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Location Name</th>
                        <th>Location Slug</th>
                        <?php if(!isset($location)): ?>
                            <th>Sub Locations</th>
                        <?php endif; ?>

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $all_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $al): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($al->name); ?></td>
                            <td><?php echo e($al->slug); ?></td>
                            <?php if(!isset($location)): ?>
                                <td>
                                    <?php $sub_locations = \App\Location::getSubLocations($al->id);?>
                                    <?php $__currentLoopData = $sub_locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-yellow"><?php echo e($sl->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                            <?php endif; ?>
                            <td>
                                <a href="<?php echo e(route('administrator.location.edit.get',[$al->id])); ?>" class="btn btn-primary">Edit</a>
                                <a href="<?php echo e(route('administrator.sub-location.add.get.id',[$al->id])); ?>" class="btn btn-success">Add New Sub Location</a>
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