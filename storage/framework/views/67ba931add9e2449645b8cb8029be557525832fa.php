

<?php $__env->startSection('title'); ?> Posting ad on selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    
    <!-- Page Content -->
    <div class="row white-bg">
        
        <div class="col-md-12 add-top">
            <h3>Welcome Shafna! Let's post an ad. Choose any option below:</h3>
        </div>

        <div class="col-md-12 add-mid">
            <div class="row">

                <div class="col-md-6 add-mid-left">
                    <div class="card">
                        <div class="card-body">
                            
                            <img src="<?php echo e(asset('web-photos/icon-money.png')); ?>" class="" alt="Responsive image">

                            <h3>Sell something:</h3>
                            <ul>
                                <li><a href="/ads/post-ad/for-sale/item-or-service">Sell an item or service <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                <li><a href="/ads/post-ad/for-rent/property-rental">Offer a property for rent <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                <!--<li><a href="/ads/post-ad/for-job/jobs">Post job vacancy <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>-->
                            </ul>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 add-mid-right">
                    <div class="card">
                        <div class="card-body">
                            <img src="<?php echo e(asset('web-photos/icon-search.png')); ?>" class="" alt="Responsive image">
                           
                            <h3>Look for something:</h3>
                            <ul>
                                <li><a href="/ads/post-ad/to-rent/property-rental">Look for property to rent <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                <li><a href="/ads/post-ad/to-buy/item-or-service">Look for something to buy <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
       
        <!--<div class="col-md-12 add-bot">
            <hr>
            <div class="allow-box">
                <img src="<?php echo e(asset('web-photos/icon-tag.png')); ?>" class="" alt="Responsive image">
                <h3>Your posting allowance</h3>
                <a href="#">Learn more about posting ads on ikman.</a>
            </div> 
        </div>-->

    </div>

    <div class="row white-bg rules-box">
        <div class="col-md-12">
            <h3>Quick rules</h3>
        </div>
        <div class="col-md-12">
            <h4>All ads posted on selfee.lk must follow our rules:</h4>
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li>Make sure you post in the correct category.</li>
                        <li>Do not post the same ad more than once or repost an ad within 48 hours.</li>
                        <li>Do not upload pictures with watermarks.</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul>
                    <li>Do not post ads containing multiple items unless it's a package deal.</li>
                    <li>Do not put your email or phone numbers in the title or description.</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--<div class="col-md-12">
            <a href="#">Click here to see all of our posting rules <i class="fa fa-angle-right" aria-hidden="true"></i></a>
        </div>-->
    </div>
    <!-- Page Content -->
          
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>