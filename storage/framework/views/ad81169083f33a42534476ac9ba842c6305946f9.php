

<?php $__env->startSection('title', 'AdminLTE'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $ad_parent_category_details = \App\Category::getParentCategoryByCategoryId($ad->category_id);
        $ad_parent_category_slug = $ad_parent_category_details->slug;
    ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.dashboard')); ?>">Home</a> </li>
                <?php 
                    if($ad->status == 0){
                ?>
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.new.ads.list')); ?>">New Ads</a></li>
                <?php } else {?>
                <li class="breadcrumb-item"><a href="<?php echo e(route('administrator.published.ads.list')); ?>">Published Ads</a></li>
                <?php }?>
                <li class="breadcrumb-item active" aria-current="page">View</li>
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
                <h4><?php echo e($ad->title); ?></h4>
                <p>
                    <?php 
                        if(($ad->ad_types->slug) == 'to-rent' || ($ad->ad_types->slug) == 'to-buy'){
                            echo 'Wanted ';
                        }
                    ?>
                    <?php echo e($ad->ad_types->name); ?> 
                    by <?php echo e($ad->customers->name); ?> <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo e(date('Y M d g:i a', strtotime($ad->created_at))); ?> <i class="fa fa-map-marker" aria-hidden="true"></i> 
                    <?php echo e($ad->locations->name); ?>

                </p>
            </div>
            <div class="panel-body">
                <div class="row adz-photo">
                    <?php if($ad->type_id != '5'): ?>
                    <div class="col-md-6">
                        <div class="row">
                            <?php $__currentLoopData = $ad->ad_photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4">
                                <img src="<?php echo e(asset('ad-photos/'.$ad_photo->title)); ?>" style="max-width: 600px; width: 100%;"> 
                            </div>     
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div> 
                    <?php endif; ?>       
                    
                    <div class="col-md-6 more-detail">
                        <?php if($ad_parent_category_slug == 'electronics'): ?>
                            <?php if(isset($ad->electronics_ads->condition)): ?>
                            <p><b>Condition:</b> <?php echo e($ad->electronics_ads->condition); ?></p>
                            <?php endif; ?>
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

                        <?php if(isset($ad->price)): ?>
                        <?php $price = str_replace(".00", "", (string)number_format ($ad->price, 2)); ?>
                            <p>
                                <b>Price:</b> Rs <?php echo e($price); ?>

                                <?php if(isset($ad->properties_ads->land_size)): ?>
                                    <?php echo e($ad->properties_ads->price_unit); ?>

                                <?php endif; ?>
                                <?php if($ad->negotiable == '1'): ?>
                                    <b>(Negotiable)</b>
                                <?php endif; ?>
                            </p>                         
                        <?php endif; ?>
                        
                        <p>
                            <b>Description:</b> 
                            <?php echo nl2br(e($ad->description)); ?>

                        </p>

                        <p>
                            <b>Contact Number(s):</b>
                            <?php $__currentLoopData = $ad->user_phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                - <?php echo e($user_phone->mobile_number); ?> 
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </p>

                        <?php if($ad->status == 0) { ?>
                        <form action="<?php echo e(route('administrator.ads.approve.post',[$ad->id])); ?>" method="post" style="float: left; margin: 10px 10px 10px 0;">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="hidden" id="ad_id" name="ad_id" value="<?php echo e($ad->id); ?>">
                            <button class="btn btn-success" id="ad_approve_btn">Approve this Ad</button>                                
                        </form>
                        <a href="<?php echo e(route('administrator.ads.reject.get',[$ad->id])); ?>" class="btn btn-danger" style="float: left; margin: 10px 10px 10px 0;">Reject this Ad</a>
                        
                        <?php } ?>
                    </div>
                </div>
                       
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>