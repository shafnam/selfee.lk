<?php $__env->startSection('title'); ?> Edit ad on selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row white-bg add-cat">
    
    <div class="col-lg-12">
        
            <?php echo Form::open(['action' => ['AdsController@update', $ad->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']); ?>

                
            <?php 
                if($adCategoryParent->slug == 'electronics'){ $sub_table = $ad->electronics_ads; }
                else if($adCategoryParent->slug == 'cars-vehicles'){ $sub_table = $ad->vehicles_ads; }
                else if($adCategoryParent->slug == 'property'){ $sub_table = $ad->properties_ads; }
                else if($adCategoryParent->slug == 'home-garden'){ $sub_table = $ad->home_garden_ads; }
                else if($adCategoryParent->slug == 'fashion-health-beauty'){ $sub_table = $ad->health_beauty_ads; }
                else if($adCategoryParent->slug == 'hobby-sport-kids'){ $sub_table = $ad->sport_kids_ads; }
                else if($adCategoryParent->slug == 'business-industry'){ $sub_table = $ad->business_industry_ads; }
                else if($adCategoryParent->slug == 'services'){ $sub_table = $ad->services_ads; }
                else if($adCategoryParent->slug == 'education'){ $sub_table = $ad->education_ads; }
                else if($adCategoryParent->slug == 'animals'){ $sub_table = $ad->animals_ads; }
                else if($adCategoryParent->slug == 'food-agriculture'){ $sub_table = $ad->food_ads; }
                else if($adCategoryParent->slug == 'other'){ $sub_table = $ad->other_ads; }                
            ?>
                <!-- Ad type id & name -->
                <input type="hidden" name="ad_type_id" value="<?php echo e($ad->ad_types->id); ?>">
                <input type="hidden" name="ad_type" value="<?php echo e($ad->ad_types->slug); ?>">

                <!-- Category-->
                <div class="col-lg-7 col-md-7 cat-sec">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                    Category: <?php echo e($adCategoryParent->name); ?>

                    <i aria-hidden="true" class="fa fa-long-arrow-right"></i>
                    <?php echo e($ad->categories->name); ?>

                    <hr>
                    <input type="hidden" name="category" value="<?php echo e($ad->categories->slug); ?>">
                    <input type="hidden" name="parent_category" value="<?php echo e($adCategoryParent->slug); ?>">
                </div>

                <!-- Location-->
                <div class="col-lg-7 col-md-7 cat-sec" style="margin-top: 0px;">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                    Location: <?php echo e($adLocationParent->name); ?>

                    <i aria-hidden="true" class="fa fa-long-arrow-right"></i>
                    <?php echo e($ad->locations->name); ?>

                    <hr>
                </div>

                <!-- Ad photos-->
                <?php if($ad->ad_types->slug != 'to-buy' && $ad->ad_types->slug != 'to-rent'): ?>
                    <div class="col-lg-7 col-md-7 td-box2">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Add photo (5 for free)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <?php if(count($ad->ad_photos) > 0): ?>
                                <?php $i = 0; ?>
                                <?php $__currentLoopData = $ad->ad_photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad_photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $i++; ?>
                                    <div class="row m-3 p-3 edit-img-preview upimg ad_img-<?php echo $i; ?>">
                                        <div class="col-lg-4">
                                            <img src="/storage/ad-photos/<?php echo e($ad_photo->title); ?>" class="img-fluid" alt="Responsive image">
                                        </div>
                                        <div class="col-lg-8">      
                                            <input type="hidden" name="file_upload[]" value="<?php echo e($ad_photo->id); ?>">          
                                        </div>
                                        <a href="javascript:void(0);" id='remove-<?php echo $i; ?>' class="remImg">
                                            <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                            Delete Image
                                        </a>                                                              
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            
                                <div class="input-files">
                                    <!-- new upload div is added here -->                         
                                </div>

                            <?php $imgCount = count($ad->ad_photos); ?>
                            <input type="hidden" name="e_img_count" id="e_img_count" value="<?php echo e($imgCount); ?>">
                            
                            <?php if(count($ad->ad_photos) < 5): ?>
                            <div class="row">
                                <div id='editAddAnother' class="col-lg-12">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" class="addImg"> Add Another Image</a>
                                </div>
                                <span class="text-danger"><?php echo e($errors->first('images_error')); ?></span>
                                <span class="text-danger"><?php echo e($errors->first('file_upload')); ?></span>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endif; ?>

                <!-- AD DETAILS -->

                <div class="col-lg-7 col-md-7">
                    <h4 class="fill-de">Ad details</h4>
                    <hr>
                </div>
            
                <!-- Title -->
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="title">Title</label> 
                            <input type="text" name="title" value="<?php echo e($ad->title); ?>" id="title" class="form-control">
                            <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                        </div>
                    </div>
                <?php if($ad->ad_types->slug != 'to-buy' && $ad->ad_types->slug != 'to-rent'): ?>
                <!-- These fields are not available for 'to buy'  and 'to rent' category -->
                
                <!-- Condition -->
                    <?php if(isset($sub_table->condition)): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="condition" class="control-label">Condition</label>
                            <div class="control-label">
                                <input type="radio" name="condition"  value="New" 
                                <?php echo e($sub_table->condition == 'New' ? 'checked' : ''); ?> >
                                <label for="new">New</label>
                                <input type="radio" name="condition" value="Used" 
                                <?php echo e($sub_table->condition == 'Used' ? 'checked' : ''); ?> >
                                <label for="new">Used</label>
                            <?php if(($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'auto-parts-accessories' ||
                                ($ad->categories->slug) == 'boats-water-transport' ): ?>
                                <input type="radio" name="condition"  value="Reconditioned" 
                                <?php echo e($sub_table->condition == 'Reconditioned' ? 'checked' : ''); ?> >
                                <label for="new">Reconditioned</label>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Type -->
                    <?php if(isset($sub_table->type)): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                        <?php 
                            if( ($ad->categories->slug) == 'cars'){ $Type = 'Body Type'; } 
                            else if(($ad->categories->slug) == 'heavy-machinery-tractors'){ $Type = 'Vehicle Type'; }
                            else if(($ad->categories->slug) == 'auto-services' || ($adCategoryParent->slug) == 'services'){ $Type = 'Service Type'; }
                            else if(($ad->categories->slug) == 'commercial-property' || ($ad->categories->slug) == 'portions-rooms' || ($ad->categories->slug) == 'holiday-short-term-rental' ){ $Type = 'Property Type'; }
                            else if(($ad->categories->slug) == 'land'){ $Type = 'Land Type'; }
                            else if(($ad->categories->slug) == 'furniture'){ $Type = 'Furniture Type'; }
                            else if(($ad->categories->slug) == 'musical-instruments'){ $Type = 'Instrument Type'; }
                            else if(($ad->categories->slug) == 'sports-equipment') { $Type = 'Equipment Type'; }  
                            else if(($ad->categories->slug) == 'pets') { $Type = 'Pet Type'; }  
                            else if(($ad->categories->slug) == 'farm-animals') { $Type = 'Animal Type'; }     
                            else if(($ad->categories->slug) == 'food') { $Type = 'Food Type'; } 
                            else if(($ad->categories->slug) == 'auto-parts-accessories' || ($ad->categories->slug) == 'travel-events-tickets' || ($ad->categories->slug) == 'music-books-movies' || ($ad->categories->slug) == 'childrens-items'){ $Type = 'Item Type'; }
                            else{ $Type = 'Type'; } 
                        ?>
                            <label for="type" class="control-label"><?php echo e($Type); ?></label>     
                            <div class="control-label">
                                <select id="type" name="type" class="form-control">
                                <?php 
                                    if(($ad->categories->slug) == 'cars'){
                                        $types = \App\Type::getCarTypesDetails($ad->categories->id);
                                    }else{
                                        $types = \App\Type::getTypesDetails($ad->categories->id);
                                    }
                                ?>
                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->name); ?>" <?php echo e($type->name == $sub_table->type ? 'selected' : ''); ?> >
                                        <?php echo e($type->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <span class="text-danger"><?php echo e($errors->first('type')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Brand -->
                    <?php if(isset($sub_table->brand)): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="brand" class="control-label">Brand</label>     
                            <div class="control-label">
                                <select id="brand" name="brand" class="form-control">
                                    <?php 
                                        $brands = \App\Brand::getBrandsDetails($ad->categories->id);
                                    ?>
                                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->name); ?>" <?php echo e($brand->name == $sub_table->brand ? 'selected' : ''); ?> >
                                        <?php echo e($brand->name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <span class="text-danger"><?php echo e($errors->first('brand')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Model -->
                    <?php if(isset($sub_table->model)): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="model" class="control-label">Model</label>     
                            <input placeholder="Model" name="model" type="text" value="<?php echo e($sub_table->model); ?>" id="model" class="form-control">
                            <span class="text-danger"><?php echo e($errors->first('model')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Model Year-->
                    <?php if( ($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'motorbikes-scooters' || ($ad->categories->slug) == 'three-wheelers' 
                    || ($ad->categories->slug) == 'vans-buses-lorries' || ($ad->categories->slug) == 'heavy-machinery-tractors'): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="modelYear" class="control-label">Model Year</label>
                            <input step="any" name="modelYear" type="number" value="<?php echo e($sub_table->model_year); ?>" id="modelYear" class="form-control">     
                            <span class="text-danger"><?php echo e($errors->first('modelYear')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Mileage (km)-->
                    <?php if( ($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'motorbikes-scooters' || ($ad->categories->slug) == 'three-wheelers'
                    || ($ad->categories->slug) == 'vans-buses-lorries' ): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="mileage" class="control-label">Mileage (Km)</label>
                            <input step="any" name="mileage" type="number" value="<?php echo e($sub_table->mileage); ?>" id="mileage" class="form-control">     
                            <span class="text-danger"><?php echo e($errors->first('mileage')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Transmission -->
                    <?php if( ($ad->categories->slug) == 'cars' ): ?>
                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <?php if( ($ad->categories->slug) == 'cars'){ $Type = 'Transmission'; }?>
                                <label for="transmission" class="control-label"><?php echo e($Type); ?></label>     
                                <div class="control-label">
                                    <select id="transmission" name="transmission" class="form-control">
                                        <?php $transmissions = \App\Type::getTransmissionsDetails($ad->categories->id); ?>
                                        <?php $__currentLoopData = $transmissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($transmission->name); ?>" <?php echo e($transmission->name == $sub_table->type ? 'selected' : ''); ?> >
                                            <?php echo e($transmission->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <span class="text-danger"><?php echo e($errors->first('transmission')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                <!-- Fuel Type -->
                    <?php if( ($ad->categories->slug) == 'cars' ): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="fuelType" class="control-label">Fuel Type</label>
                            <div class="control-label">
                                <input type="radio" name="fuelType"  value="Diesel" 
                                <?php echo e($sub_table->fuel_type == 'Diesel' ? 'checked' : ''); ?> >
                                <label for="new">Diesel</label>
                                <input type="radio" name="fuelType" value="Petrol" 
                                <?php echo e($sub_table->fuel_type == 'Petrol' ? 'checked' : ''); ?> >
                                <label for="new">Petrol</label>
                                <input type="radio" name="fuelType"  value="CNG" 
                                <?php echo e($sub_table->fuel_type == 'CNG' ? 'checked' : ''); ?> >
                                <label for="new">CNG</label>
                                <input type="radio" name="fuelType"  value="Other" 
                                <?php echo e($sub_table->fuel_type == 'Other' ? 'checked' : ''); ?> >
                                <label for="new">Other</label>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Engine capacity (cc)-->
                    <?php if( ($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'motorbikes-scooters' || ($ad->categories->slug) == 'vans-buses-lorries' ): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="engineCapacity" class="control-label">Engine capacity (cc)</label>   
                            <input step="any" name="engineCapacity" type="number" value="<?php echo e($sub_table->engine_capacity); ?>" id="engineCapacity" class="form-control">  
                            <span class="text-danger"><?php echo e($errors->first('engineCapacity')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Authenticity -->
                    <?php if(isset($sub_table->authenticity)): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="authenticity" class="control-label">Authenticity</label>     
                            <div class="control-label"> 
                                <input type="radio" name="authenticity"  value="Original" 
                                <?php echo e($sub_table->authenticity == 'Original' ? 'checked' : ''); ?> >
                                <label for="new">Original</label>
                                <input type="radio" name="authenticity" value="Replica" 
                                <?php echo e($sub_table->authenticity == 'Replica' ? 'checked' : ''); ?> >
                                <label for="new">Replica</label>    
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <!-- Features -->
                    <?php $cat_features_count = \App\Feature::catFeaturesCount($ad->categories->id); ?>
                    <?php if($cat_features_count > 0): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="features" class="control-label">Features (optional)</label> 
                            <div class="control-label">
                            <?php $features = \App\Feature::getFeaturesDetails($ad->categories->id); ?>
                            <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="checkbox" name="feature[]"  value="<?php echo e($feature->title); ?>"
                                <?php
                                    foreach($ad->ad_features as $ad_feature){
                                        if($feature->title == $ad_feature->title){ echo 'checked'; }
                                    }
                                ?> > 
                                <?php echo e($feature->title); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                
                <!-- Land Size -->
                    <?php if( ($ad->categories->slug) == 'land' || ($ad->categories->slug) == 'houses'): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-6">
                                    <label for="landSize" class="control-label">Land Size</label>
                                    <input step="any" name="landSize" type="number" value="<?php echo e($sub_table->land_size); ?>" id="landSize" class="form-control">     
                                    <span class="text-danger"><?php echo e($errors->first('landSize')); ?></span>
                                </div>
                                <!-- Unit -->
                                <div class="col-lg-4 col-md-6">
                                    <label for="landUnit" class="control-label">Land Unit</label>
                                    <div class="control-label">
                                        <select id="landUnit" name="landUnit" class="form-control">
                                            <option value="perches" <?php echo e($sub_table->land_unit == 'perches' ? 'selected' : ''); ?> >perches</option>
                                            <option value="acres" <?php echo e($sub_table->land_unit == 'acres' ? 'selected' : ''); ?> >acres</option>
                                        </select>
                                    </div>
                                    <span class="text-danger"><?php echo e($errors->first('landUnit')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                <!-- Size -->
                    <?php if( ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'commercial-property'
                    || ($ad->categories->slug) == 'shoes-footwear' ): ?>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <?php 
                                if(($ad->categories->slug) == 'houses'){ $Size = 'House Size';}
                                else if(($ad->categories->slug) == 'commercial-property'){ $Size = 'Property Size'; }
                                else if(($ad->categories->slug) == 'shoes-footwear'){ $Size = 'Size (optional)';}
                                else{ $Size = 'Size'; $placeholder = 'Size'; } 
                            ?>
                            <label for="size"><?php echo e($Size); ?></label>
                            <input step="any" name="size" type="number" value="<?php echo e($sub_table->size); ?>" id="size" class="form-control">
                            <span class="text-danger"><?php echo e($errors->first('size')); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                <!-- Bedrooms & Bathrooms-->
                    <?php if( ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'portions-rooms'
                    || ($ad->categories->slug) == 'holiday-short-term-rental'): ?>
                    <!-- Bedrooms-->
                    <div class="col-lg-7 col-md-7">
                        
                        <label for="bedrooms" class="control-label">Bedrooms</label>            
                        <div class="control-label">
                            <select id="bedrooms" name="bedrooms" class="form-control">
                            <?php 
                            for($i=1; $i<=10; $i++){ ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($sub_table->bedrooms == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                            <?php } ?>
                                <option value="10+" <?php echo e($sub_table->bedrooms == '10+' ? 'selected' : ''); ?>>10+</option>
                            </select>
                        </div>
                        <span class="text-danger"><?php echo e($errors->first('bedrooms')); ?></span>
                        
                    </div>
                    <!-- Bathrooms-->
                    <div class="col-lg-7 col-md-7">
                        
                            <label for="bathrooms" class="control-label">Bathrooms</label>            
                            <div class="control-label">
                                <select id="bathrooms" name="bathrooms" class="form-control">
                                <?php 
                                for($i=1; $i<=10; $i++){ ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e($sub_table->bathrooms == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                <?php } ?>
                                    <option value="10+" <?php echo e($sub_table->bathrooms == '10+' ? 'selected' : ''); ?>>10+</option>
                                </select>
                            </div>
                            <span class="text-danger"><?php echo e($errors->first('bathrooms')); ?></span>
                      
                    </div>
                    <?php endif; ?>   
                    
                <!-- Address -->
                    <?php if( ($ad->categories->slug) == 'land' || ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'commercial-property'
                    || ($ad->categories->slug) == 'portions-rooms' || ($ad->categories->slug) == 'holiday-short-term-rental'): ?>
                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <label for="address">Address (optional)</label> 
                                <input placeholder="Address" name="address" type="text" value="<?php echo e($sub_table->address); ?>" id="address" class="form-control"> 
                                <span class="text-danger"><?php echo e($errors->first('address')); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                <!-- Gender -->
                    <?php if( ($ad->categories->slug) == 'clothing' || ($ad->categories->slug) == 'shoes-footwear' || ($ad->categories->slug) == 'childrens-items'): ?>
                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <label for="gender" class="control-label">Gender (optional)</label>
                                <div class="control-label"> 
                                <?php if(($ad->categories->slug) == 'childrens-items'): ?>
                                    <input id="boys" name="gender" type="radio" value="Boys" <?php echo e($sub_table->gender == 'Boys' ? 'checked' : ''); ?>> <label for="boys">Boys</label> 
                                    <input id="girls" name="gender" type="radio" value="Girls" <?php echo e($sub_table->gender == 'Girls' ? 'checked' : ''); ?>> <label for="girls">Girls</label> 
                                    <input id="baby" name="gender" type="radio" value="Baby" <?php echo e($sub_table->gender == 'Baby' ? 'checked' : ''); ?>> <label for="baby">Baby</label>
                                <?php else: ?>
                                    <input id="male" name="gender" type="radio" value="Male" <?php echo e($sub_table->gender == 'Male' ? 'checked' : ''); ?>> 
                                    <label for="male">Male</label> 
                                    <input id="female" name="gender" type="radio" value="Female" <?php echo e($sub_table->gender == 'Female' ? 'checked' : ''); ?>> 
                                    <label for="female">Female</label>
                                <?php endif; ?>
                                    <input id="unisex" name="gender" type="radio" value="Unisex" <?php echo e($sub_table->gender == 'Unisex' ? 'checked' : ''); ?>> 
                                    <label for="unisex">Unisex</label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                
                <?php endif; ?>

                <!-- Description -->
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>   
                            <textarea rows="6" cols="50" name="description"  id="description" class="form-control"><?php echo e($ad->description); ?>

                            </textarea>  
                            <span class="text-danger"><?php echo e($errors->first('description')); ?></span>
                        </div>
                    </div>

                <?php if($ad->ad_types->slug != 'to-buy' && $ad->ad_types->slug != 'to-rent'): ?>
                <!-- Price -->
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4">
                                <?php 
                                    if( ($adCategoryParent->slug) == 'services' ){ $Price = 'Price (Rs) (optional)'; } 
                                    else if( $ad->ad_types->slug == 'for-rent' && (($ad->categories->slug) == 'portions-rooms' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'commercial-property') ){ $Price = 'Rent (Rs) /month' ;}  
                                    else if( $ad->ad_types->slug == 'for-rent' &&  ($ad->categories->slug) == 'holiday-short-term-rental' ){ $Price = 'Rent (Rs) /night' ;} 
                                    else if( $ad->ad_types->slug == 'for-rent' &&  ($ad->categories->slug) == 'land' ){ $Price = 'Rent (Rs) /year' ;}  
                                    else { $Price = 'Price (Rs)';} 
                                ?>
                                    <label for="price" class="control-label"><?php echo e($Price); ?></label> 
                                    <input placeholder="Price (Rs)" step="any" name="price" type="number" value="<?php echo e($ad->price); ?>" id="price" class="form-control">
                                </div>
                                <?php if( ($ad->categories->slug) == 'land' && $ad->ad_types->slug == 'for-sale'): ?>
                                <!-- Price Unit -->
                                <div class="col-lg-4">
                                    <label for="priceUnit" class="control-label">Unit</label>
                                    <div class="control-label">
                                        <select id="priceUnit" name="priceUnit" class="form-control">
                                            <option value="total price" <?php echo e($sub_table->price_unit == 'total price' ? 'selected' : ''); ?> >total price</option>
                                            <option value="per perch" <?php echo e($sub_table->price_unit == 'per perch' ? 'selected' : ''); ?> >per perch</option>
                                            <option value="per acre" <?php echo e($sub_table->price_unit == 'per acre' ? 'selected' : ''); ?> >per acre</option>
                                        </select>
                                    </div>
                                    <span class="text-danger"><?php echo e($errors->first('priceUnit')); ?></span>
                                </div>
                                <?php endif; ?>
                                <!-- Negotiable -->                                
                                <div class="col-lg-4">
                                    <input type="checkbox" name="negotiable"  value="Negotiable" 
                                    <?php echo e($ad->negotiable == '1' ? 'checked' : ''); ?> >
                                    <label for="new" style="margin-top: 38px;">Negotiable</label>
                                </div>
                            </div>
                            <span class="text-danger"><?php echo e($errors->first('price')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- CONTACT DETAILS -->

                <div class="col-lg-7 col-md-7">
                    <h4 class="fill-de">Contact details</h4>
                    <hr>
                </div>
    
                <!-- Contact Name -->
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <label for="contact_name" class="control-label">Contact Name</label> 
                        <input type="text" name="contact_name" value="<?php echo e(Auth::user()->name); ?>" class="form-control" readonly>
                    </div>
                </div>

                <!-- Contact Numbers -->
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <div class="phone-no-box">
                            <p class="pno-title">Phone number(s)</p>
                            <div class="e_phone-numbers">
                                <?php if($ad->user_phones->count() > 0): ?>
                                    <?php $i = 0; ?>
                                    <?php $__currentLoopData = $ad->user_phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $i++; ?>
                                        <p class="p-no e_p-no-<?php echo $i; ?>">
                                            <input type="text" name="e_phone_number[]" value="<?php echo e($user_phone->mobile_number); ?>" class="phone-nums" readonly>
                                            <a href="javascript:void(0);" id='e_phone-remove-<?php echo $i; ?>' class="e_phone-remove">
                                                <i class="fa fa-minus-circle e_remove-num" aria-hidden="true"></i>
                                            </a>
                                        </p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php $pnCount = count($ad->user_phones); ?>
                                <input type="hidden" name="e_phone_count" id="e_phone_count" value="<?php echo e($pnCount); ?>">
                            </div>
                            
                            <span id ="e_pno-message" style="color: red;"></span>
                            <a href="javascript:void(0);" id="e_sbmtPhone" style="display: none;">Add this number</a><br/>
                            
                            <?php if($pnCount == 0): ?>
                            <div class="e_pno-add" id="e_dp">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='e_addPhone' class="e_addPhone"> Add a phone number</a>
                            </div>
                            <?php else: ?>
                            <div class="e_pno-add" id="e_dp">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='e_addPhone' class="e_addPhone"> Add another phone number</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- ./CONTACT DETAILS -->                

                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo e(form::hidden('_method', 'PUT')); ?>

                        <?php echo e(form::submit('Edit Ad', ['class' => 'btn btn-primary'])); ?>

                    </div>
                </div>

            <?php echo Form::close(); ?>

        
    </div>   

</div>

<div class="row white-bg rules-box">
    <div class="col-md-12">
        <h3>Quick rules</h3>
    </div>
    <div class="col-md-12">
        <h4>All ads posted on ikman.lk must follow our rules:</h4>
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
    <div class="col-md-12">
        <a href="#">Click here to see all of our posting rules <i class="fa fa-angle-right" aria-hidden="true"></i></a>
    </div>
</div>
        
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>