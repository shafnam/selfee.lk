<?php $__env->startSection('title'); ?> Posting ad on selfee.lk <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row white-bg add-cat">
    
    <div class="col-lg-12 add-cat-topic" style="margin-bottom: 0px;">
    <?php if($getAdTypeDetails->name == 'For Sale'){ ?>
            <h3>Sell an item or service </h3>
    <?php } else if($getAdTypeDetails->name == 'For Rent'){ ?>
            <h3>Offer a property for rent</h3>
    <?php } else if($getAdTypeDetails->name == 'To Rent'){ ?>
            <h3>Look for property to rent</h3>
    <?php } else if($getAdTypeDetails->name == 'To Buy'){ ?>
            <h3>Look for something to buy</h3>
    <?php } ?>
            <hr>
    </div>
    
    <div class="col-lg-12">
        
        <?php echo Form::open(['name' => 'uploadFile', 'action' => 'AdsController@store', 'method' => 'POST', 'id'=> 'ad-upload-form', 'enctype' => 'multipart/form-data']); ?>

            
            <!-- Ad type id & name -->
            <input type="hidden" name="ad_type_id" value="<?php echo e($getAdTypeDetails->id); ?>">
            <input type="hidden" name="ad_type" value="<?php echo e($getAdTypeDetails->slug); ?>">
            
            <!-- Category-->
            <div class="col-lg-7 col-md-7 cat-sec">
                <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                Category: <?php echo e($getCatParentDetails->name); ?> 
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
                <?php if(strpos($getCatDetails->name , '_fs') !== false) { 
                    $getCatDetails->name  = str_replace('_fs', '', $getCatDetails->name);
                ?>
                    <?php echo e($getCatDetails->name); ?>

                <?php } else { ?>
                    <?php echo e($getCatDetails->name); ?>

                <?php } ?>
                <input type="hidden" name="parent_category" value="<?php echo e($getCatParentDetails->slug); ?>">
                <input type="hidden" name="category" value="<?php echo e($getCatDetails->slug); ?>">
                <input type="hidden" name="category_id" value="<?php echo e($getCatDetails->id); ?>">
                <span class="r-change"><a href="/ads/post-ad/<?php echo e($getAdTypeDetails->slug); ?>/<?php echo e($type); ?>">Change</a></span>
                <hr>
            </div>
        
            <!-- Location-->
            <div class="col-lg-7 col-md-7 cat-sec" style="margin-top: 0px;">
                <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                Location: <?php echo e($getLocParentDetails->name); ?> 
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
                <?php echo e($getLocDetails->name); ?>

                <input type="hidden" name="location_id" value="<?php echo e($getLocDetails->id); ?>">
                <span class="r-change"><a href="/ads/post-ad/<?php echo e($getAdTypeDetails->slug); ?>/<?php echo e($type); ?>/<?php echo e($getCatDetails->parent_id); ?>/<?php echo e($getCatDetails->slug); ?>">Change</a></span>
                <hr>
            </div>

            <!-- Ad photos-->
            <?php if($getAdTypeDetails->slug != 'to-buy' && $getAdTypeDetails->slug != 'to-rent'): ?>
            <div class="col-lg-7 col-md-7 td-box2">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Add photo (5 for free)</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <div class="input-files">
                        <div class="row m-3 p-2 upimg img-1 ">
                            <div class="col-lg-4">
                                <div id="uploadPreview-1" class="prev-img"></div>
                            </div>
                            <div class="col-lg-8">
                                <label for="file-upload" class="custom-file-upload" id="file-up-btn-1">
                                    Add a Photo
                                </label>        
                                <input type="file" name="file_upload[]">
                            </div>
                            <!--<a href="javascript:void(0);" id='remove-1' class="remImg" style="display:none;">Remove</a>-->
                            <a href="javascript:void(0);" id='remove-1' class="remImg" style="display:none;">
                                <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                Delete Image
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div id='addAnother' class="col-lg-12" style="display:none;">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" class="addImg"> Add Another Image</a>
                        </div>
                        <span class="text-danger"><?php echo e($errors->first('file_upload')); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <!-- ./Ad photos-->

            <!-- AD DETAILS -->

            <div class="col-lg-7 col-md-7">
                <h4 class="fill-de">Fill in the details</h4>
                <hr>
            </div>

            <!-- Title -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <?php echo Form::label('title', 'Title'); ?>

                    <?php echo Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Your ad\'s name' ]); ?>

                    <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                </div>
            </div>
            
            <?php if($getAdTypeDetails->slug != 'to-buy' && $getAdTypeDetails->slug != 'to-rent'): ?>
            <!-- These fields are not available for 'to buy'  and 'to rent' category -->
            
            <!-- Condition -->
                <?php if(($getCatDetails->slug) != 'auto-services' 
                && ($getCatParentDetails->slug) != 'property' && ($getCatDetails->slug) != 'sports-supplements' 
                && ($getCatDetails->slug) != 'licences-titles' && ($getCatDetails->slug) != 'other-business-services' 
                && ($getCatParentDetails->slug) != 'services' && ($getCatDetails->slug) != 'higher-education'
                && ($getCatDetails->slug) != 'tuition' && ($getCatDetails->slug) != 'vocational-institutes'
                && ($getCatDetails->slug) != 'other-education' && ($getCatDetails->slug) != 'pets' 
                && ($getCatDetails->slug) != 'pet-food' && ($getCatDetails->slug) != 'veterinary-services' 
                && ($getCatDetails->slug) != 'farm-animals' && ($getCatDetails->slug) != 'other-animals' 
                && ($getCatParentDetails->slug) != 'food-agriculture' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('condition', 'Condition', ['class' => 'control-label']); ?>

                        <div class="control-label"> 
                            <?php echo Form::radio('condition', 'New', true, ['id' => 'new']); ?>

                            <?php echo Form::label('new', 'New'); ?>

                            <?php echo Form::radio('condition', 'Used', false, ['id' => 'used']); ?>

                            <?php echo Form::label('used', 'Used'); ?>

                            <?php if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'auto-parts-accessories' ||
                            ($getCatDetails->slug) == 'boats-water-transport' ): ?>
                            <?php echo Form::radio('condition', 'Reconditioned', false, ['id' => 'reconditioned']); ?>

                            <?php echo Form::label('reconditioned', 'Reconditioned'); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            
            <!-- Type -->
                <?php if( ($getCatDetails->slug) == 'computers-tablets' || ($getCatDetails->slug) == 'computer-accessories' || ($getCatDetails->slug) == 'tv-video-accessories'
                || ($getCatDetails->slug) == 'cameras-camcorders' || ($getCatDetails->slug) == 'audio-mp3' 
                || ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'heavy-machinery-tractors' || ($getCatDetails->slug) == 'auto-services'
                || ($getCatDetails->slug) == 'auto-parts-accessories' || ($getCatDetails->slug) == 'land' || ($getCatDetails->slug) == 'commercial-property'
                || ($getCatDetails->slug) == 'furniture' || ($getCatDetails->slug) == 'health-beauty-products' || ($getCatDetails->slug) == 'musical-instruments'
                || ($getCatDetails->slug) == 'sports-equipment' || ($getCatDetails->slug) == 'travel-events-tickets' || ($getCatDetails->slug) == 'music-books-movies' 
                || ($getCatDetails->slug) == 'childrens-items' || ($getCatDetails->slug) == 'other-business-services' || ($getCatParentDetails->slug) == 'services' 
                || ($getCatDetails->slug) == 'textbooks' || ($getCatDetails->slug) == 'tuition' || ($getCatDetails->slug) == 'pets' || ($getCatDetails->slug) == 'farm-animals'
                || ($getCatDetails->slug) == 'food' || ($getCatDetails->slug) == 'portions-rooms' || ($getCatDetails->slug) == 'holiday-short-term-rental'): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php 
                            if(($getCatDetails->slug) == 'cars'){ $AdType = 'Body Type'; } 
                            else if(($getCatDetails->slug) == 'heavy-machinery-tractors'){ $AdType = 'Vehicle Type'; } 
                            else if(($getCatDetails->slug) == 'auto-services' || 
                            ($getCatParentDetails->slug) == 'services'){ $AdType = 'Service Type'; }
                            else if(($getCatDetails->slug) == 'auto-parts-accessories' || 
                            ($getCatDetails->slug) == 'travel-events-tickets' || 
                            ($getCatDetails->slug) == 'music-books-movies' || 
                            ($getCatDetails->slug) == 'childrens-items'){ $AdType = 'Item Type'; }
                            else if(($getCatDetails->slug) == 'land'){ $AdType = 'Land Type'; }
                            else if(($getCatDetails->slug) == 'commercial-property' || ($getCatDetails->slug) == 'portions-rooms' || ($getCatDetails->slug) == 'holiday-short-term-rental' ){ $AdType = 'Property Type'; }
                            else if(($getCatDetails->slug) == 'furniture'){ $AdType = 'Furniture Type'; }
                            else if(($getCatDetails->slug) == 'musical-instruments'){ $AdType = 'Instrument Type'; }   
                            else if(($getCatDetails->slug) == 'sports-equipment') { $AdType = 'Equipment Type'; }  
                            else if(($getCatDetails->slug) == 'pets') { $AdType = 'Pet Type'; }  
                            else if(($getCatDetails->slug) == 'farm-animals') { $AdType = 'Animal Type'; }     
                            else if(($getCatDetails->slug) == 'food') { $AdType = 'Food Type'; }                      
                            else{ $AdType = 'Type'; } 
                        ?>
                        <?php echo Form::label('type', $AdType, ['class' => 'control-label'] ); ?>                
                        <div class="control-label">
                            <?php if(($getCatDetails->slug) == 'cars'): ?>
                            <?php echo Form::select('type', $getBodyTypes, null, ['class' => 'form-control']); ?>

                            <?php else: ?>
                            <?php echo Form::select('type', $getTypes, null, ['class' => 'form-control']); ?>

                            <?php endif; ?>
                        </div>
                        <span class="text-danger"><?php echo e($errors->first('type')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Brand -->
                <?php if( ($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'computers-tablets' || ($getCatDetails->slug) == 'tvs'
                || ($getCatDetails->slug) == 'cameras-camcorders' || ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' 
                || ($getCatDetails->slug) == 'vans-buses-lorries' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('brand', 'Brand', ['class' => 'control-label'] ); ?>                
                        <div class="control-label">
                            <?php echo Form::select('brand', $getBrands, null, ['class' => 'form-control']); ?>

                        </div>
                        <span class="text-danger"><?php echo e($errors->first('brand')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Model -->
                <?php if( ($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'computers-tablets' || ($getCatDetails->slug) == 'tvs'
                || ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters'
                || ($getCatDetails->slug) == 'vans-buses-lorries' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('model', 'Model'); ?>

                        <?php echo Form::text('model', '', ['class' => 'form-control', 'placeholder' => 'Model']); ?>

                        <span class="text-danger"><?php echo e($errors->first('model')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Model Year-->
                <?php if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' || ($getCatDetails->slug) == 'three-wheelers' 
                || ($getCatDetails->slug) == 'vans-buses-lorries' || ($getCatDetails->slug) == 'heavy-machinery-tractors'): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('modelYear', 'Model Year'); ?>

                        <?php echo Form::number('modelYear', '', ['class' => 'form-control', 'placeholder' => 'Model Year','step'=>'any']); ?>

                        <span class="text-danger"><?php echo e($errors->first('modelYear')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Mileage (km)-->
                <?php if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' || ($getCatDetails->slug) == 'three-wheelers'
                || ($getCatDetails->slug) == 'vans-buses-lorries' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('mileage', 'Mileage (km)'); ?>

                        <?php echo Form::number('mileage', '', ['class' => 'form-control', 'placeholder' => 'Mileage (km)','step'=>'any']); ?>

                        <span class="text-danger"><?php echo e($errors->first('mileage')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Transmission -->
                <?php if( ($getCatDetails->slug) == 'cars' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('transmission', 'Transmission', ['class' => 'control-label'] ); ?>                
                        <div class="control-label">
                            <?php echo Form::select('transmission', $getTranmissions, null, ['class' => 'form-control']); ?>

                        </div>
                        <span class="text-danger"><?php echo e($errors->first('transmission')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Fuel Type -->
                <?php if( ($getCatDetails->slug) == 'cars' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('fuelType', 'Fuel Type', ['class' => 'control-label']); ?>

                        <div class="control-label"> 
                            <?php echo Form::radio('fuelType', 'Diesel', true, ['id' => 'diesel']); ?>

                            <?php echo Form::label('diesel', 'Diesel'); ?>

                            <?php echo Form::radio('fuelType', 'Petrol', false, ['id' => 'petrol']); ?>

                            <?php echo Form::label('petrol', 'Petrol'); ?>

                            <?php echo Form::radio('fuelType', 'CNG', false, ['id' => 'cng']); ?>

                            <?php echo Form::label('cng', 'CNG'); ?>

                            <?php echo Form::radio('fuelType', 'Other', false, ['id' => 'other']); ?>

                            <?php echo Form::label('other', 'Other'); ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Engine capacity (cc)-->
                <?php if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' || ($getCatDetails->slug) == 'vans-buses-lorries' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('engineCapacity', 'Engine capacity (cc)'); ?>

                        <?php echo Form::number('engineCapacity', '', ['class' => 'form-control', 'placeholder' => 'Engine capacity (cc)','step'=>'any']); ?>

                        <span class="text-danger"><?php echo e($errors->first('engineCapacity')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Authenticity -->
                <?php if(($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'watches'): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('authenticity', 'Authenticity', ['class' => 'control-label']); ?>

                        <div class="control-label"> 
                            <?php echo Form::radio('authenticity', 'Original', true, ['id' => 'original']); ?>

                            <?php echo Form::label('original', 'Original'); ?>

                            <?php echo Form::radio('authenticity', 'Replica', false, ['id' => 'replica']); ?>

                            <?php echo Form::label('replica', 'Replica'); ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Features -->
                <?php if(($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'portions-rooms'): ?>
                <div class="col-lg-7 col-md-7">
                    <!-- Checkboxes -->
                    <div class="form-group">
                        <?php echo Form::label('features', 'Features (optional)', ['class' => 'control-label']); ?>

                        <div class="control-label">
                            <?php $__currentLoopData = $getFeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getFeature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <?php echo Form::checkbox('features[]', $getFeature); ?> <?php echo e($getFeature); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Bedrooms & Bathrooms-->
                <?php if( ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'portions-rooms'
                || ($getCatDetails->slug) == 'holiday-short-term-rental'): ?>
                <!-- Bedrooms-->
                <div class="col-lg-7 col-md-7">
                    <?php echo Form::label('bedrooms', 'Bedrooms', ['class' => 'control-label'] ); ?>                
                    <div class="control-label">
                        <?php echo Form::select('bedrooms', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '10+' => '10+'], null, ['class' => 'form-control', 'placeholder' => 'Select...']); ?>

                    </div>
                    <span class="text-danger"><?php echo e($errors->first('bedrooms')); ?></span>
                </div>
                <!-- Bathrooms-->
                <div class="col-lg-7 col-md-7">
                    <?php echo Form::label('bathrooms', 'Bathrooms', ['class' => 'control-label'] ); ?>                
                    <div class="control-label">
                        <?php echo Form::select('bathrooms', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '10+' => '10+'], null, ['class' => 'form-control', 'placeholder' => 'Select...']); ?>

                    </div>
                    <span class="text-danger"><?php echo e($errors->first('bathrooms')); ?></span>
                </div>
                <?php endif; ?>

            <!-- Land Size -->
                <?php if( ($getCatDetails->slug) == 'land' || ($getCatDetails->slug) == 'houses'): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-8 col-md-6">
                                <?php echo Form::label('landSize', 'Land Size'); ?>

                                <?php echo Form::number('landSize', '', ['class' => 'form-control', 'placeholder' => 'Land Size','step'=>'any']); ?>

                                <span class="text-danger"><?php echo e($errors->first('landSize')); ?></span>
                            </div>
                            <!-- Unit -->
                            <div class="col-lg-4 col-md-6">
                                <?php echo Form::label('landUnit', 'Land Unit', ['class' => 'control-label'] ); ?>                
                                <div class="control-label">
                                    <?php echo Form::select('landUnit', ['perches' => 'perches', 'acres' => 'acres'], 'perches', ['class' => 'form-control']); ?>

                                </div>
                                <span class="text-danger"><?php echo e($errors->first('landUnit')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <!--  Size -->
                <?php if( ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'commercial-property'
                || ($getCatDetails->slug) == 'shoes-footwear' ): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php 
                            if(($getCatDetails->slug) == 'houses'){ $Size = 'House Size'; $placeholder = 'Size (sqft)'; }
                            else if(($getCatDetails->slug) == 'commercial-property'){ $Size = 'Property Size'; $placeholder = 'Size (sqft)'; }
                            else if(($getCatDetails->slug) == 'shoes-footwear'){ $Size = 'Size'; $placeholder = 'Size (optional)'; }
                            else{ $Size = 'Size'; $placeholder = 'Size'; } 
                        ?>
                        <?php echo Form::label('size', $Size); ?>

                        <?php echo Form::number('size', '', ['class' => 'form-control', 'placeholder' => $placeholder,'step'=>'any']); ?>

                        <span class="text-danger"><?php echo e($errors->first('size')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Address -->
                <?php if( ($getCatDetails->slug) == 'land' || ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'commercial-property'
                || ($getCatDetails->slug) == 'portions-rooms' || ($getCatDetails->slug) == 'holiday-short-term-rental'): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('address', 'Address (optional)'); ?>

                        <?php echo Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address' ]); ?>

                        <span class="text-danger"><?php echo e($errors->first('address')); ?></span>
                    </div>
                </div>
                <?php endif; ?>

            <!-- Gender -->
                <?php if( ($getCatDetails->slug) == 'clothing' || ($getCatDetails->slug) == 'shoes-footwear' || ($getCatDetails->slug) == 'childrens-items'): ?>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php echo Form::label('gender', 'Gender (optional)', ['class' => 'control-label']); ?>

                        <div class="control-label"> 
                            <?php if(($getCatDetails->slug) == 'childrens-items'): ?>
                                <?php echo Form::radio('gender', 'Boys', false, ['id' => 'boys']); ?>

                                <?php echo Form::label('boys', 'Boys'); ?>

                                <?php echo Form::radio('gender', 'Girls', false, ['id' => 'girls']); ?>

                                <?php echo Form::label('girls', 'Girls'); ?>

                                <?php echo Form::radio('gender', 'Baby', false, ['id' => 'baby']); ?>

                                <?php echo Form::label('baby', 'Baby'); ?>

                            <?php else: ?>
                                <?php echo Form::radio('gender', 'Male', false, ['id' => 'male']); ?>

                                <?php echo Form::label('male', 'Male'); ?>

                                <?php echo Form::radio('gender', 'Female', false, ['id' => 'female']); ?>

                                <?php echo Form::label('female', 'Female'); ?>

                            <?php endif; ?>
                            <?php echo Form::radio('gender', 'Unisex', false, ['id' => 'unisex']); ?>

                            <?php echo Form::label('unisex', 'Unisex'); ?>

                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Description -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <?php echo Form::label('description', 'Description'); ?>

                    <?php echo Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Ad description here...', 'rows' => 6]); ?>

                    <span class="text-danger"><?php echo e($errors->first('description')); ?></span>
                </div>
            </div>

            <?php if($getAdTypeDetails->slug != 'to-buy' && $getAdTypeDetails->slug != 'to-rent'): ?>
            <!-- Price -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4">
                        <?php 
                            if( ($getCatParentDetails->slug) == 'services' ){ $Price = 'Price (Rs) (optional)'; } 
                            else if( $getAdTypeDetails->slug == 'for-rent' && (($getCatDetails->slug) == 'portions-rooms' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'commercial-property') ){ $Price = 'Rent (Rs) /month' ;}  
                            else if( $getAdTypeDetails->slug == 'for-rent' &&  ($getCatDetails->slug) == 'holiday-short-term-rental' ){ $Price = 'Rent (Rs) /night' ;} 
                            else if( $getAdTypeDetails->slug == 'for-rent' &&  ($getCatDetails->slug) == 'land' ){ $Price = 'Rent (Rs) /year' ;}  
                            else { $Price = 'Price (Rs)';} ?>
                            <?php echo Form::label('price', $Price); ?>

                            <?php echo Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Price (Rs)','step'=>'any']); ?>

                        </div>
                        <?php if( ($getCatDetails->slug) == 'land' && $getAdTypeDetails->slug == 'for-sale'): ?>
                        <!-- Price Unit -->
                        <div class="col-lg-4">
                            <?php echo Form::label('priceUnit', 'Unit', ['class' => 'control-label'] ); ?>                
                            <div class="control-label">
                                <?php echo Form::select('priceUnit', ['total price' => 'total price', 'per perch' => 'per perch', 'per acre' => 'per acre'], 'total price', ['class' => 'form-control']); ?>

                            </div>
                            <span class="text-danger"><?php echo e($errors->first('priceUnit')); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="col-lg-4">
                            <?php echo Form::label(' ', '', ['style' => 'height: 50px'] ); ?> 
                            <?php echo Form::checkbox('negotiable', 'Negotiable'); ?> Negotiable
                        </div>
                    </div>
                    <span class="text-danger"><?php echo e($errors->first('price')); ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- ./AD DETAILS -->

            <!-- CONTACT DETAILS -->

            <div class="col-lg-7 col-md-7">
                <h4 class="fill-de">Contact details</h4>
                <hr>
            </div>

            <!-- Contact Name -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <?php echo Form::label('contactName', 'Contact Name'); ?>

                    <?php echo Form::text('contactName', Auth::user()->name, ['class' => 'form-control','readonly']); ?>

                </div>
            </div>

            <!-- Contact Numbers -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <div class="phone-no-box">
                        <p class="pno-title">Phone number(s)</p>
                        <div class="phone-numbers">
                        <?php if(count($getPhones) > 0): ?>
                            <?php $i = 0; ?>
                            <?php $__currentLoopData = $getPhones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getPhone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <?php $i++; ?>
                                <p class="p-no p-no-<?php echo $i; ?>">
                                    <?php echo Form::text('phone_number[]', $getPhone, ['class' => 'phone-nums', 'readonly']); ?>

                                    <a href="javascript:void(0);" id='phone-remove-<?php echo $i; ?>' class="phone-remove">
                                        <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                    </a>
                                </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                            <?php $pnCount = count($getPhones); ?>
                            <input type="hidden" name="phone_count" id="phone_count" value="<?php echo e($pnCount); ?>">
                        </div>
                        
                        <span id ="pno-message" style="color: red;"></span>
                        <a href="javascript:void(0);" id="sbmtPhone" style="display: none;">Add this number</a><br/>
                        
                        <?php if($pnCount == 0): ?>
                        <div class="pno-add" id="dp">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='addPhone' class="addPhone"> Add a phone number</a>
                        </div>
                        <?php else: ?>
                        <div class="pno-add" id="dp">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='addPhone' class="addPhone"> Add another phone number</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <?php echo Form::label('contactEmail', 'Email'); ?>

                    <?php echo Form::email('contactEmail', Auth::user()->email, ['class' => 'form-control','readonly']); ?>

                </div>
            </div>

            <!-- ./CONTACT DETAILS -->
            
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <?php echo e(form::submit('Post Ad', ['class' => 'btn btn-primary'])); ?>

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