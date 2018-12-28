<?php use Carbon\Carbon; ?>


<?php $__env->startSection('title'); ?> My Ads <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?> 

<?php echo $__env->make('inc.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="container">
    <div class="row white-bg rules-box myaccount-page">
        <div class="col-md-12 help-box2">
            <div class="row">
                <div class="col-lg-3 col-md-4 help-left">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" href="/dashboard">My account <span class="help-arrow"><i class="fa fa-angle-right fa-lg" aria-hidden="true"></i></span></a>
                        <a class="nav-link" href="/customers/settings">Settings</a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 help-right">
                    <div class="tab-content">
                        <div class="tab-pane fade show active faq-box">
                            <h3><?php echo e(Auth::user()->name); ?></h3>
                            <hr>
                            <?php if(count($rejected_ads) || count($published_ads) > 0 ): ?>
                                <?php if(count($rejected_ads) > 0): ?>
                                    <div class="my-add-box">
                                        <div class="alert alert-secondary" role="alert">
                                            Rejected ads <span class="badge badge-light" style="background: black"><?php echo count($rejected_ads); ?></span>
                                        </div>
                                    </div>                            
                                    <?php $__currentLoopData = $rejected_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card publish-ad-box">
                                            <div class="card-body" style="border-left: 2px solid red; background: #77777717;">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img src="<?php echo e(asset('ad-photos/'.$ad->ad_photos->first()->title)); ?>" class="img-fluid com-img" style="-webkit-filter: grayscale(100%); filter: grayscale(70%);">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <a class="pbox-1" href="<?php echo e(url('ads/'.$ad->slug )); ?>"><?php echo e($ad->title); ?></a>
                                                        <h4><?php echo e(Auth::user()->name); ?></h4>
                                                        <p class="pbox-2">
                                                            <?php 
                                                                $created = new Carbon($ad->created_at);
                                                                $now = Carbon::now();
                                                                $difference = ($created->diff($now)->days < 1)? 'Today': $created->diffForHumans($now);
                                                            ?>
                                                            <?php echo e($difference); ?>, 
                                                            <?php echo e($ad->locations->name); ?>. <em><?php echo e($ad->categories->name); ?></em>
                                                        </p>
                                                        
                                                        <!--<p class="pbox-3" style="color: red;">Reason for rejecting: </p>-->
                                                       
                                                        <a href="/ads/post-ad" class="btn btn-dark ad-edit-btn btn-sm m-2">Post Again</a>
                                                        <?php echo Form::open(['action' => ['AdsController@destroy', $ad->id], 'method' => 'POST']); ?>

                                                            <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                                            <?php echo e(Form::submit('Delete', ['class' => 'btn btn-danger ad-delete-btn btn-sm m-2'])); ?>

                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                            
                                    <hr>
                                <?php endif; ?>
                                <?php if(count($published_ads) > 0): ?>
                                    <div class="my-add-box">
                                        <div class="alert alert-secondary" role="alert">
                                            Published ads <span class="badge badge-light" style="background: black"><?php echo count($published_ads); ?></span>
                                        </div>
                                    </div>                            
                                    <?php $__currentLoopData = $published_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="card publish-ad-box">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img src="<?php echo e(asset('ad-photos/'.$ad->ad_photos->first()->title)); ?>" class="img-fluid com-img" alt="Responsive image">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <a class="pbox-1" href="<?php echo e(url('ads/'.$ad->slug )); ?>"><?php echo e($ad->title); ?></a>
                                                        <h4><?php echo e(Auth::user()->name); ?></h4>
                                                        <p class="pbox-2">
                                                            <?php 
                                                                $created = new Carbon($ad->created_at);
                                                                $now = Carbon::now();
                                                                $difference = ($created->diff($now)->days < 1)? 'Today': $created->diffForHumans($now);
                                                            ?>
                                                            <?php echo e($difference); ?>, 
                                                            <?php echo e($ad->locations->name); ?>. <em><?php echo e($ad->categories->name); ?></em>
                                                        </p>
                                                        <!--<p class="pbox-3"><i class="fa fa-eye" aria-hidden="true"></i> <b>169</b> Views</p>-->
                                                        <a href="/ads/<?php echo e($ad->id); ?>/edit" class="btn btn-dark ad-edit-btn btn-sm m-2">Edit</a>
                                                        <?php echo Form::open(['action' => ['AdsController@destroy', $ad->id], 'method' => 'POST']); ?>

                                                            <?php echo e(Form::hidden('_method', 'DELETE')); ?>

                                                            <?php echo e(Form::submit('Delete', ['class' => 'btn btn-danger ad-delete-btn btn-sm m-2'])); ?>

                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>                            
                            <?php else: ?>
                            <div class="account-box">                                
                                <h3>You don't have any ads yet.</h3>
                                <p>Click the "Post an ad now!" button to post your ad.</p>
                                <a href="/ads/post-ad" class="btn btn-dark postad-btn">Post your ad now!</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>