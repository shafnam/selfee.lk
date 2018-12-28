<?php $__env->startSection('title'); ?>
    <?php echo e($ad->categories->name); ?> :
    <?php echo e($ad->title); ?> | <?php echo e($ad->locations->name); ?> | selfee
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <div class="container-fluid gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <a href="<?php echo e(url('/')); ?>">Home</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <a href="<?php echo e(url('ads')); ?>">All ads</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- get location parent -->
                        <?php $loc_parent_details = \App\Location::getSingleLocationParent($ad->locations->parent_id); ?>
                        <a href="<?php echo e(url('ads/location/'.$loc_parent_details->slug )); ?>"><?php echo e($loc_parent_details->name); ?></a><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- location -->
                        <a href="<?php echo e(url('ads/location/')); ?>/<?php echo e($ad->locations->slug); ?>"><?php echo e($ad->locations->name); ?></a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- get category parent -->
                        <?php $cat_parent_details = \App\Category::getSingleCategoryParent($ad->categories->parent_id); ?>
                        <a href="<?php echo e(url('ads/category/'.$cat_parent_details->slug )); ?>"><?php echo e($cat_parent_details->name); ?></a><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- category -->
                        <a href="<?php echo e(url('ads/category/')); ?>/<?php echo e($ad->categories->slug); ?>"><?php echo e($ad->categories->name); ?></a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <em><?php echo e($ad->title); ?></em>
                    </p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="show-container">
    <!-- Page Content -->
    <div class="row add-info-main">
        <div class="col-md-12">

        <?php
            $ad_parent_category_details = \App\Category::getParentCategoryByCategoryId($ad->category_id);
            $ad_parent_category_slug = $ad_parent_category_details->slug;
        ?>
            
            <div class="row adz-info">
                <div class="col-md-12">
                    <h2><?php echo e($ad->title); ?></h2>
                    <p><?php 
                        if(($ad->ad_types->slug) == 'to-rent' || ($ad->ad_types->slug) == 'to-buy'){
                            echo 'Wanted ';
                        }
                        ?>
                        <?php echo e($ad->ad_types->name); ?> 
                        by <?php echo e($ad->customers->name); ?> <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo e(date('Y M d g:i a', strtotime($ad->created_at))); ?> <i class="fa fa-map-marker" aria-hidden="true"></i> 
                        <?php echo e($ad->locations->name); ?>

                    </p>
                </div>
            </div>

            <?php if($ad->type_id != '5'): ?>
            <div class="row adz-photo">
                <div class="col-md-7">
                    <div class="item" style="border: 1px solid #efefef; padding: 1rem;">
                        <div class="clearfix" style="max-width: 600px; margin: 0px auto;">
                            <ul id="image-gallery" class="gallery list-unstyled cS-hidden" style="margin: 0 auto;">
                                <?php $__currentLoopData = $ad->ad_photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li data-thumb="<?php echo e(asset('ad-photos/'.$ad_photo->title)); ?>">
                                        <img src="<?php echo e(asset('ad-photos/'.$ad_photo->title)); ?>" class="img-fluid" style="margin-right: auto; margin-left: auto; display: block;">
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 more-detail">
                    <div class="row adz-contact">
                        <!--<div class="col-md-2 pt-3">                            
                            <i aria-hidden="true" class="fa fa-phone"></i>                         
                        </div>-->
                        <div class="col-md-12">
                            <!--<form method="GET" action="#phones" style="margin-left: -15px;">
                                <button class="gtm-show-number-button" data-target=".item-phones">
                                    <?php 
                                    $phone_number = $ad->user_phones->first()->mobile_number;
                                    $phone_number = substr($phone_number, 0, 5);  
                                    ?>                                  
                                    <span class="gtm-show-number">
                                        <i class="fa fa-phone" aria-hidden="true"></i> 
                                        <?php echo  $phone_number;?>*****                     
                                    </span>
                                    <span style="padding-left: 0.5rem;">Click to show phone number</span>
                                </button>
                                <input type="hidden" name="phones" value="1">
                            </form>-->
                            <button id="showPhone" class="gtm-show-number-button" data-target=".item-phones">
                                <?php 
                                $phone_number = $ad->user_phones->first()->mobile_number;
                                $phone_number = substr($phone_number, 0, 5);  
                                ?>
                                <h4><span>&#9742;</span> <?php echo  $phone_number;?>*****</h4> 
                                <p>Click to show phone number</p>                            
                                                    
                                <!--<span class="gtm-show-number">
                                    <i class="fa fa-phone" aria-hidden="true"></i> 
                                    <?php echo  $phone_number;?>*****  
                                    <br/>
                                    <span style="padding-left: 0;">Click to show phone number</span>                   
                                </span>-->                           
                                
                            </button>                            
                        </div>
                    </div>
                    <div id="phones" class="row adz-contact" style="display:none;">
                        <div class="col-md-12">
                            <hr>
                            <h3>Contact</h3>
                            <?php $__currentLoopData = $ad->user_phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <h3><span>&#9742;</span>  <?php echo e($user_phone->mobile_number); ?></h3>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <hr>
                    <?php if($ad_parent_category_slug == 'electronics'): ?>
                        <p><b>Condition:</b> <?php echo e($ad->electronics_ads->condition); ?></p>
                        <?php if(isset($ad->electronics_ads->brand)): ?>
                            <p><b>Brand:</b> <?php echo e($ad->electronics_ads->brand); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->electronics_ads->model)): ?>
                            <p><b>Model:</b> <?php echo e($ad->electronics_ads->model); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->electronics_ads->authenticity)): ?>
                            <p><b>Authenticity:</b> <?php echo e($ad->electronics_ads->authenticity); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->electronics_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->electronics_ads->type); ?></p>
                        <?php endif; ?>
                        <?php if(count($ad->ad_features)> 0): ?>
                            <p><b>Features:</b>
                                <?php $__currentLoopData = $ad->ad_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo e($ad_feature->title); ?>,
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'cars-vehicles'): ?>
                        <?php if(isset($ad->vehicles_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->vehicles_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->brand)): ?>
                            <p><b>Brand:</b> <?php echo e($ad->vehicles_ads->brand); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->model)): ?>
                            <p><b>Model:</b> <?php echo e($ad->vehicles_ads->model); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->model_year)): ?>
                            <p><b>Model Year:</b> <?php echo e($ad->vehicles_ads->model_year); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->vehicles_ads->type); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->transmission)): ?>
                            <p><b>Transmission:</b> <?php echo e($ad->vehicles_ads->transmission); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->fuel_type)): ?>
                            <p><b>Fuel Type:</b> <?php echo e($ad->vehicles_ads->fuel_type); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->engine_capacity)): ?>
                            <p><b>Engine Capacity:</b> <?php echo e($ad->vehicles_ads->engine_capacity); ?> CC</p>
                        <?php endif; ?>
                        <?php if(isset($ad->vehicles_ads->mileage)): ?>
                            <p><b>Mileage:</b> <?php echo e($ad->vehicles_ads->mileage); ?> Km</p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'property'): ?>
                        <?php if(isset($ad->properties_ads->bedrooms)): ?>
                            <p><b>Bedrooms:</b> <?php echo e($ad->properties_ads->bedrooms); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->properties_ads->bathrooms)): ?>
                            <p><b>Bathrooms:</b> <?php echo e($ad->properties_ads->bathrooms); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->properties_ads->size)): ?>
                            <p><b>House Size:</b> <?php echo e($ad->properties_ads->size); ?> sqft</p>
                        <?php endif; ?>
                        <?php if(isset($ad->properties_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->properties_ads->type); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->properties_ads->land_size)): ?>
                            <p><b>Land Size:</b> <?php echo e($ad->properties_ads->land_size); ?> <?php echo e($ad->properties_ads->land_unit); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->properties_ads->address)): ?>
                            <p><b>Address:</b> <?php echo e($ad->properties_ads->address); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'home-garden'): ?>
                        <?php if(isset($ad->home_garden_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->home_garden_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->home_garden_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->home_garden_ads->type); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'fashion-health-beauty'): ?>
                        <?php if(isset($ad->health_beauty_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->health_beauty_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->health_beauty_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->health_beauty_ads->type); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->health_beauty_ads->gender)): ?>
                            <p><b>Gender:</b> <?php echo e($ad->health_beauty_ads->gender); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->health_beauty_ads->size)): ?>
                            <p><b>Size:</b> <?php echo e($ad->health_beauty_ads->size); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->health_beauty_ads->authenticity)): ?>
                            <p><b>Authenticity:</b> <?php echo e($ad->health_beauty_ads->authenticity); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'hobby-sport-kids'): ?>
                        <?php if(isset($ad->sport_kids_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->sport_kids_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->sport_kids_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->sport_kids_ads->type); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->sport_kids_ads->gender)): ?>
                            <p><b>Gender:</b> <?php echo e($ad->sport_kids_ads->gender); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'business-industry'): ?>
                        <?php if(isset($ad->business_industry_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->business_industry_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->business_industry_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->business_industry_ads->type); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'services'): ?>
                        <?php if(isset($ad->services_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->services_ads->type); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'education'): ?>
                        <?php if(isset($ad->education_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->education_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->education_ads->type)): ?>
                        <p><b>Type:</b> <?php echo e($ad->education_ads->type); ?></p>
                    <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'animals'): ?>
                        <?php if(isset($ad->animals_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->animals_ads->condition); ?></p>
                        <?php endif; ?>
                        <?php if(isset($ad->animals_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->animals_ads->type); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'food-agriculture'): ?>
                        <?php if(isset($ad->food_ads->type)): ?>
                            <p><b>Type:</b> <?php echo e($ad->food_ads->type); ?></p>
                        <?php endif; ?>
                    <?php elseif($ad_parent_category_slug == 'other'): ?>
                        <?php if(isset($ad->other_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->other_ads->condition); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                    <hr>
                </div>
            </div>
            <?php endif; ?>

            <div class="row adz-more-info">
                <!-- Basic ad info -->
                <div class="col-md-9">
                    <p>
                        <?php if(isset($ad->price)): ?>
                        <span class="price">
                            <?php $price = str_replace(".00", "", (string)number_format ($ad->price, 2)); ?>
                            Rs <?php echo e($price); ?>

                            <?php if(isset($ad->properties_ads->land_size)): ?>
                                <?php echo e($ad->properties_ads->price_unit); ?>

                            <?php endif; ?>
                        </span>
                        <?php endif; ?>
                        <?php if($ad->negotiable == '1'): ?>
                            <em>Negotiable</em>
                        <?php endif; ?>
                    </p>

                    <p><?php echo nl2br(e($ad->description)); ?></p>
                </div>
                <!-- /.Basic ad info -->
            </div>
        </div>

    </div>
    <div class="row similar-adz">
        <div class="col-md-12">
            <hr>
            <h3>Similar Ads</h3>
        </div>
        <div class="col-md-12 sa-right">
            <div class="row">
                <?php 
                    $relatedAds = \App\Ad::getRelatedAdsByCatSlug($ad_parent_category_slug);
                ?>
                <?php $__currentLoopData = $relatedAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedAd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo e(asset('ad-photos/'.$relatedAd->ad_photos->first()->title)); ?>" alt="Card image cap">
                        <div class="card-body">
                            <a href="<?php echo e(url('ads/'.$relatedAd->slug )); ?>"><?php echo e($relatedAd->title); ?></a>
                            <p class="add-details"><?php echo e($relatedAd->price); ?></p>
                            <p class="add-loca"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo e($ad_parent_category_details->name); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
    <!-- Page Content -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>