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
                        <!--<a class="nav-link" href="/membership">My membership</a>
                        <a class="nav-link" href="/resume">My resume</a>
                        <a class="nav-link" href="/favorites">Favorites</a>-->
                        <a class="nav-link" href="/users/settings">Settings</a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 help-right">
                    <div class="tab-content">
                        <div class="tab-pane fade show active faq-box">
                            <h3><?php echo e(Auth::user()->name); ?></h3>
                            <hr>
                            <?php if(count($ads) > 0): ?>
                                <div class="my-add-box">
                                    <div class="alert alert-secondary" role="alert">
                                        Published ads <span class="badge badge-light" style="background: black"><?php echo count($ads); ?></span>
                                    </div>
                                </div>                            
                                <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card publish-ad-box">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img src="/storage/ad-photos/<?php echo e($ad->ad_photos->first()->title); ?>" class="img-fluid com-img" alt="Responsive image">
                                                </div>
                                                <div class="col-md-9">
                                                    <a class="pbox-1" href="<?php echo e(url('ads/'.$ad->slug )); ?>"><?php echo e($ad->title); ?></a>
                                                    <h4><?php echo e(Auth::user()->name); ?></h4>
                                                    <p class="pbox-2"><span class="badge badge-dark">Member</span> 6 days, Colombo. Jobs in Sri Lanka</p>
                                                    <p class="pbox-3"><i class="fa fa-eye" aria-hidden="true"></i> <b>169</b> Views</p>
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
                            <?php else: ?>
                            <div class="account-box">                                
                                <h3>You don't have any ads yet.</h3>
                                <p>Click the "Post an ad now!" button to post your ad.</p>
                                <a href="/ads/post-ad" class="btn btn-dark postad-btn">Post your ad now!</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!--- -->
                    <div class="tab-content my-ads">
                        <div class="tab-pane fade show active faq-box">
                            <h3>W. I Tell Solutions (PVT) Ltd</h3>
                            <hr>
                            <div class="my-add-box">
                                <div class="alert alert-secondary" role="alert">
                                    Ads that need editing <span class="badge badge-light">1</span>
                                </div>
                            </div>

                            <div class="alert alert-warning" role="alert">
                                <h3><i class="fa fa-exclamation-circle" aria-hidden="true"></i> You have ads that need to be edited!</h3>
                                <p>Click edit to correct your ad and submit it for publishing again. You can also click "Delete" to remove any ads. <b>Unedited ads are automatically removed after 7 days.!</b></p>
                            </div>

                            <div class="ad-wrong-box">
                                <div class="row">
                                    <div class="col-md-12 adr-top">
                                        <p><b>Reason :</b> Wrong category</p>
                                    </div>
                                    <div class="col-md-12 adr-mid">
                                        <img src="images/wi-tel-logo.png" class="img-fluid" alt="Responsive image">
                                        <h4>Transport</h4>
                                        <p>Colombo, Travel & Tourism</p>
                                    </div>
                                    <div class="col-md-12 adr-bot">
                                        <div class="s-box">
                                            <button type="button" class="btn btn-dark ad-edit-btn btn-sm">Edit</button>
                                            <button type="button" class="btn btn-danger ad-delete-btn btn-sm">Delete</button>
                                        </div>
                                        <p><i class="fa fa-exclamation-circle" aria-hidden="true"></i> 3 days left to edit this ad!</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 m-ad-4">
                                    <a href="#">See all Rejected ads <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i></a>
                                </div>
                            </div>


                            <div class="my-add-box">
                                <div class="alert alert-secondary" role="alert">
                                    Published ads <span class="badge badge-light" style="background: black">12</span>
                                </div>
                            </div>

                            <div class="card publish-ad-box">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="images/wi-tel-logo.png" class="img-fluid com-img" alt="Responsive image">
                                        </div>
                                        <div class="col-md-9">
                                            <a class="pbox-1" href="#">Intern Android Application Developer</a>
                                            <h4>W. I Tell Solutions Pvt Ltd</h4>
                                            <p class="pbox-2"><span class="badge badge-dark">Member</span> 6 days, Colombo. Jobs in Sri Lanka</p>
                                            <p class="pbox-3"><i class="fa fa-eye" aria-hidden="true"></i> <b>169</b> Views <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                                            <button type="button" class="btn btn-dark ad-edit-btn btn-sm">Edit</button>
                                            <button type="button" class="btn btn-danger ad-delete-btn btn-sm">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="images/bump-ad.png" class="img-fluid com-img" alt="Responsive image">
                                        </div>
                                        <div class="col-md-7">
                                            <p>Reach up to 10x more people by promoting your ad.</p>
                                        </div>
                                        <div class="col-md-3 promo-box">
                                            <button type="button" class="btn btn-dark btn-sm">Promote this ad</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card publish-ad-box">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="images/wi-tel-logo.png" class="img-fluid com-img" alt="Responsive image">
                                        </div>
                                        <div class="col-md-9">
                                            <a class="pbox-1" href="#">Intern Android Application Developer</a>
                                            <h4>W. I Tell Solutions Pvt Ltd</h4>
                                            <p class="pbox-2"><span class="badge badge-dark">Member</span> 6 days, Colombo. Jobs in Sri Lanka</p>
                                            <p class="pbox-3"><i class="fa fa-eye" aria-hidden="true"></i> <b>169</b> Views <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                                            <button type="button" class="btn btn-dark ad-edit-btn btn-sm">Edit</button>
                                            <button type="button" class="btn btn-danger ad-delete-btn btn-sm">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="images/bump-ad.png" class="img-fluid com-img" alt="Responsive image">
                                        </div>
                                        <div class="col-md-7">
                                            <p>Reach up to 10x more people by promoting your ad.</p>
                                        </div>
                                        <div class="col-md-3 promo-box">
                                            <button type="button" class="btn btn-dark btn-sm">Promote this ad</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card publish-ad-box">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="images/wi-tel-logo.png" class="img-fluid com-img" alt="Responsive image">
                                        </div>
                                        <div class="col-md-9">
                                            <a class="pbox-1" href="#">Intern Android Application Developer</a>
                                            <h4>W. I Tell Solutions Pvt Ltd</h4>
                                            <p class="pbox-2"><span class="badge badge-dark">Member</span> 6 days, Colombo. Jobs in Sri Lanka</p>
                                            <p class="pbox-3"><i class="fa fa-eye" aria-hidden="true"></i> <b>169</b> Views <i class="fa fa-question-circle" aria-hidden="true"></i></p>
                                            <button type="button" class="btn btn-dark ad-edit-btn btn-sm">Edit</button>
                                            <button type="button" class="btn btn-danger ad-delete-btn btn-sm">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="images/bump-ad.png" class="img-fluid com-img" alt="Responsive image">
                                        </div>
                                        <div class="col-md-7">
                                            <p>Reach up to 10x more people by promoting your ad.</p>
                                        </div>
                                        <div class="col-md-3 promo-box">
                                            <button type="button" class="btn btn-dark btn-sm">Promote this ad</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 m-ad-4">
                                    <a href="#">See all published ads <i class="fa fa-angle-right fa-lg" aria-hidden="true"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!--- -->
                </div>
            </div>
        </div>
    </div>  
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>