<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Published Ads</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                   Published Ads
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Ad Name</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Poster's name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $get_published_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gpa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($gpa->title); ?></td>
                            <td><?php echo e($gpa->categories->name); ?></td>
                            <td><?php echo e($gpa->locations->name); ?></td>
                            <td><?php echo e($gpa->customers->name); ?></td>
                            <td>
                                <a href="<?php echo e(route('administrator.ads.view.get',[$gpa->id])); ?>" class="btn btn-warning">View</a>
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