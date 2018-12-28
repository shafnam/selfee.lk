@extends('layouts.app')

@section ('title') Edit ad on selfee.lk @endsection

@section('content')

<div class="row white-bg add-cat">
    
    <div class="col-lg-12">
        
            {!! Form::open(['action' => ['AdsController@update', $ad->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                
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
                <input type="hidden" name="ad_type_id" value="{{$ad->ad_types->id}}">
                <input type="hidden" name="ad_type" value="{{$ad->ad_types->slug}}">

                <!-- Category-->
                <div class="col-lg-7 col-md-7 cat-sec">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                    Category: {{$adCategoryParent->name}}
                    <i aria-hidden="true" class="fa fa-long-arrow-right"></i>
                    {{$ad->categories->name}}
                    <hr>
                    <input type="hidden" name="category" value="{{$ad->categories->slug}}">
                    <input type="hidden" name="parent_category" value="{{$adCategoryParent->slug}}">
                </div>

                <!-- Location-->
                <div class="col-lg-7 col-md-7 cat-sec" style="margin-top: 0px;">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                    Location: {{$adLocationParent->name}}
                    <i aria-hidden="true" class="fa fa-long-arrow-right"></i>
                    {{$ad->locations->name}}
                    <hr>
                </div>

                <!-- Ad photos-->
                @if($ad->ad_types->slug != 'to-buy' && $ad->ad_types->slug != 'to-rent')
                    <div class="col-lg-7 col-md-7 td-box2">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Add photo (5 for free)</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            @if(count($ad->ad_photos) > 0)
                                <?php $i = 0; ?>
                                @foreach($ad->ad_photos as $ad_photo)
                                    <?php $i++; ?>
                                    <div class="row m-3 p-3 edit-img-preview upimg ad_img-<?php echo $i; ?>">
                                        <div class="col-lg-4">
                                            <img src="{{ asset('ad-photos/'.$ad_photo->title) }}" class="img-fluid" alt="Responsive image">
                                        </div>
                                        <div class="col-lg-8">      
                                            <input type="hidden" name="file_upload[]" value="{{$ad_photo->id}}">          
                                        </div>
                                        <a href="javascript:void(0);" id='remove-<?php echo $i; ?>' class="remImg">
                                            <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                            Delete Image
                                        </a>                                                              
                                    </div>
                                @endforeach
                            @endif
                            
                                <div class="input-files">
                                    <!-- new upload div is added here -->                         
                                </div>

                            <?php $imgCount = count($ad->ad_photos); ?>
                            <input type="hidden" name="e_img_count" id="e_img_count" value="{{$imgCount}}">
                            
                            @if(count($ad->ad_photos) < 5)
                            <div class="row">
                                <div id='editAddAnother' class="col-lg-12">
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" class="addImg"> Add Another Image</a>
                                </div>
                                <span class="text-danger">{{ $errors->first('images_error') }}</span>
                                <span class="text-danger">{{ $errors->first('file_upload') }}</span>
                            </div>
                            @endif

                        </div>
                    </div>
                @endif

                <!-- AD DETAILS -->

                <div class="col-lg-7 col-md-7">
                    <h4 class="fill-de">Ad details</h4>
                    <hr>
                </div>
            
                <!-- Title -->
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="title">Title</label> 
                            <input type="text" name="title" value="{{$ad->title}}" id="title" class="form-control">
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        </div>
                    </div>
                @if($ad->ad_types->slug != 'to-buy' && $ad->ad_types->slug != 'to-rent')
                <!-- These fields are not available for 'to buy'  and 'to rent' category -->
                
                <!-- Condition -->
                    @if(isset($sub_table->condition))
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="condition" class="control-label">Condition</label>
                            <div class="control-label">
                                <input type="radio" name="condition"  value="New" 
                                {{ $sub_table->condition == 'New' ? 'checked' : '' }} >
                                <label for="new">New</label>
                                <input type="radio" name="condition" value="Used" 
                                {{ $sub_table->condition == 'Used' ? 'checked' : '' }} >
                                <label for="new">Used</label>
                            @if(($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'auto-parts-accessories' ||
                                ($ad->categories->slug) == 'boats-water-transport' )
                                <input type="radio" name="condition"  value="Reconditioned" 
                                {{ $sub_table->condition == 'Reconditioned' ? 'checked' : '' }} >
                                <label for="new">Reconditioned</label>
                            @endif
                            </div>
                        </div>
                    </div>
                    @endif
                <!-- Type -->
                    @if(isset($sub_table->type))
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
                            <label for="type" class="control-label">{{$Type}}</label>     
                            <div class="control-label">
                                <select id="type" name="type" class="form-control">
                                <?php 
                                    if(($ad->categories->slug) == 'cars'){
                                        $types = \App\Type::getCarTypesDetails($ad->categories->id);
                                    }else{
                                        $types = \App\Type::getTypesDetails($ad->categories->id);
                                    }
                                ?>
                                    @foreach($types as $type)
                                    <option value="{{ $type->name }}" {{ $type->name == $sub_table->type ? 'selected' : '' }} >
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger">{{ $errors->first('type') }}</span>
                        </div>
                    </div>
                    @endif
                <!-- Brand -->
                    @if(isset($sub_table->brand))
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="brand" class="control-label">Brand</label>     
                            <div class="control-label">
                                <select id="brand" name="brand" class="form-control">
                                    <?php 
                                        $brands = \App\Brand::getBrandsDetails($ad->categories->id);
                                    ?>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->name }}" {{ $brand->name == $sub_table->brand ? 'selected' : '' }} >
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <span class="text-danger">{{ $errors->first('brand') }}</span>
                        </div>
                    </div>
                    @endif
                <!-- Model -->
                    @if(isset($sub_table->model))
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="model" class="control-label">Model</label>     
                            <input placeholder="Model" name="model" type="text" value="{{$sub_table->model}}" id="model" class="form-control">
                            <span class="text-danger">{{ $errors->first('model') }}</span>
                        </div>
                    </div>
                    @endif
                <!-- Model Year-->
                    @if( ($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'motorbikes-scooters' || ($ad->categories->slug) == 'three-wheelers' 
                    || ($ad->categories->slug) == 'vans-buses-lorries' || ($ad->categories->slug) == 'heavy-machinery-tractors')
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="modelYear" class="control-label">Model Year</label>
                            <input step="any" name="modelYear" type="number" value="{{$sub_table->model_year}}" id="modelYear" class="form-control">     
                            <span class="text-danger">{{ $errors->first('modelYear') }}</span>
                        </div>
                    </div>
                    @endif
                <!-- Mileage (km)-->
                    @if( ($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'motorbikes-scooters' || ($ad->categories->slug) == 'three-wheelers'
                    || ($ad->categories->slug) == 'vans-buses-lorries' )
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="mileage" class="control-label">Mileage (Km)</label>
                            <input step="any" name="mileage" type="number" value="{{$sub_table->mileage}}" id="mileage" class="form-control">     
                            <span class="text-danger">{{ $errors->first('mileage') }}</span>
                        </div>
                    </div>
                    @endif
                <!-- Transmission -->
                    @if( ($ad->categories->slug) == 'cars' )
                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <?php if( ($ad->categories->slug) == 'cars'){ $Type = 'Transmission'; }?>
                                <label for="transmission" class="control-label">{{$Type}}</label>     
                                <div class="control-label">
                                    <select id="transmission" name="transmission" class="form-control">
                                        <?php $transmissions = \App\Type::getTransmissionsDetails($ad->categories->id); ?>
                                        @foreach($transmissions as $transmission)
                                        <option value="{{ $transmission->name }}" {{ $transmission->name == $sub_table->type ? 'selected' : '' }} >
                                            {{ $transmission->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger">{{ $errors->first('transmission') }}</span>
                            </div>
                        </div>
                    @endif
                <!-- Fuel Type -->
                    @if( ($ad->categories->slug) == 'cars' )
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="fuelType" class="control-label">Fuel Type</label>
                            <div class="control-label">
                                <input type="radio" name="fuelType"  value="Diesel" 
                                {{ $sub_table->fuel_type == 'Diesel' ? 'checked' : '' }} >
                                <label for="new">Diesel</label>
                                <input type="radio" name="fuelType" value="Petrol" 
                                {{ $sub_table->fuel_type == 'Petrol' ? 'checked' : '' }} >
                                <label for="new">Petrol</label>
                                <input type="radio" name="fuelType"  value="CNG" 
                                {{ $sub_table->fuel_type == 'CNG' ? 'checked' : '' }} >
                                <label for="new">CNG</label>
                                <input type="radio" name="fuelType"  value="Other" 
                                {{ $sub_table->fuel_type == 'Other' ? 'checked' : '' }} >
                                <label for="new">Other</label>
                            </div>
                        </div>
                    </div>
                    @endif
                <!-- Engine capacity (cc)-->
                    @if( ($ad->categories->slug) == 'cars' || ($ad->categories->slug) == 'motorbikes-scooters' || ($ad->categories->slug) == 'vans-buses-lorries' )
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="engineCapacity" class="control-label">Engine capacity (cc)</label>   
                            <input step="any" name="engineCapacity" type="number" value="{{$sub_table->engine_capacity}}" id="engineCapacity" class="form-control">  
                            <span class="text-danger">{{ $errors->first('engineCapacity') }}</span>
                        </div>
                    </div>
                    @endif
                <!-- Authenticity -->
                    @if(isset($sub_table->authenticity))
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="authenticity" class="control-label">Authenticity</label>     
                            <div class="control-label"> 
                                <input type="radio" name="authenticity"  value="Original" 
                                {{ $sub_table->authenticity == 'Original' ? 'checked' : '' }} >
                                <label for="new">Original</label>
                                <input type="radio" name="authenticity" value="Replica" 
                                {{ $sub_table->authenticity == 'Replica' ? 'checked' : '' }} >
                                <label for="new">Replica</label>    
                            </div>
                        </div>
                    </div>
                    @endif
                <!-- Features -->
                    <?php $cat_features_count = \App\Feature::catFeaturesCount($ad->categories->id); ?>
                    @if($cat_features_count > 0)
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="features" class="control-label">Features (optional)</label> 
                            <div class="control-label">
                            <?php $features = \App\Feature::getFeaturesDetails($ad->categories->id); ?>
                            @foreach($features as $feature)
                                <input type="checkbox" name="feature[]"  value="{{$feature->title}}"
                                <?php
                                    foreach($ad->ad_features as $ad_feature){
                                        if($feature->title == $ad_feature->title){ echo 'checked'; }
                                    }
                                ?> > 
                                {{ $feature->title }}
                            @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                
                <!-- Land Size -->
                    @if( ($ad->categories->slug) == 'land' || ($ad->categories->slug) == 'houses')
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8 col-md-6">
                                    <label for="landSize" class="control-label">Land Size</label>
                                    <input step="any" name="landSize" type="number" value="{{$sub_table->land_size}}" id="landSize" class="form-control">     
                                    <span class="text-danger">{{ $errors->first('landSize') }}</span>
                                </div>
                                <!-- Unit -->
                                <div class="col-lg-4 col-md-6">
                                    <label for="landUnit" class="control-label">Land Unit</label>
                                    <div class="control-label">
                                        <select id="landUnit" name="landUnit" class="form-control">
                                            <option value="perches" {{ $sub_table->land_unit == 'perches' ? 'selected' : '' }} >perches</option>
                                            <option value="acres" {{ $sub_table->land_unit == 'acres' ? 'selected' : '' }} >acres</option>
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('landUnit') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                <!-- Size -->
                    @if( ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'commercial-property'
                    || ($ad->categories->slug) == 'shoes-footwear' )
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <?php 
                                if(($ad->categories->slug) == 'houses'){ $Size = 'House Size';}
                                else if(($ad->categories->slug) == 'commercial-property'){ $Size = 'Property Size'; }
                                else if(($ad->categories->slug) == 'shoes-footwear'){ $Size = 'Size (optional)';}
                                else{ $Size = 'Size'; $placeholder = 'Size'; } 
                            ?>
                            <label for="size">{{$Size}}</label>
                            <input step="any" name="size" type="number" value="{{$sub_table->size}}" id="size" class="form-control">
                            <span class="text-danger">{{ $errors->first('size') }}</span>
                        </div>
                    </div>
                    @endif

                <!-- Bedrooms & Bathrooms-->
                    @if( ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'portions-rooms'
                    || ($ad->categories->slug) == 'holiday-short-term-rental')
                    <!-- Bedrooms-->
                    <div class="col-lg-7 col-md-7">
                        
                        <label for="bedrooms" class="control-label">Bedrooms</label>            
                        <div class="control-label">
                            <select id="bedrooms" name="bedrooms" class="form-control">
                            <?php 
                            for($i=1; $i<=10; $i++){ ?>
                                <option value="{{$i}}" {{ $sub_table->bedrooms == $i ? 'selected' : '' }}>{{$i}}</option>
                            <?php } ?>
                                <option value="10+" {{ $sub_table->bedrooms == '10+' ? 'selected' : '' }}>10+</option>
                            </select>
                        </div>
                        <span class="text-danger">{{ $errors->first('bedrooms') }}</span>
                        
                    </div>
                    <!-- Bathrooms-->
                    <div class="col-lg-7 col-md-7">
                        
                            <label for="bathrooms" class="control-label">Bathrooms</label>            
                            <div class="control-label">
                                <select id="bathrooms" name="bathrooms" class="form-control">
                                <?php 
                                for($i=1; $i<=10; $i++){ ?>
                                    <option value="{{$i}}" {{ $sub_table->bathrooms == $i ? 'selected' : '' }}>{{$i}}</option>
                                <?php } ?>
                                    <option value="10+" {{ $sub_table->bathrooms == '10+' ? 'selected' : '' }}>10+</option>
                                </select>
                            </div>
                            <span class="text-danger">{{ $errors->first('bathrooms') }}</span>
                      
                    </div>
                    @endif   
                    
                <!-- Address -->
                    @if( ($ad->categories->slug) == 'land' || ($ad->categories->slug) == 'houses' || ($ad->categories->slug) == 'apartments' || ($ad->categories->slug) == 'commercial-property'
                    || ($ad->categories->slug) == 'portions-rooms' || ($ad->categories->slug) == 'holiday-short-term-rental')
                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <label for="address">Address (optional)</label> 
                                <input placeholder="Address" name="address" type="text" value="{{$sub_table->address}}" id="address" class="form-control"> 
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            </div>
                        </div>
                    @endif

                <!-- Gender -->
                    @if( ($ad->categories->slug) == 'clothing' || ($ad->categories->slug) == 'shoes-footwear' || ($ad->categories->slug) == 'childrens-items')
                        <div class="col-lg-7 col-md-7">
                            <div class="form-group">
                                <label for="gender" class="control-label">Gender (optional)</label>
                                <div class="control-label"> 
                                @if(($ad->categories->slug) == 'childrens-items')
                                    <input id="boys" name="gender" type="radio" value="Boys" {{ $sub_table->gender == 'Boys' ? 'checked' : '' }}> <label for="boys">Boys</label> 
                                    <input id="girls" name="gender" type="radio" value="Girls" {{ $sub_table->gender == 'Girls' ? 'checked' : '' }}> <label for="girls">Girls</label> 
                                    <input id="baby" name="gender" type="radio" value="Baby" {{ $sub_table->gender == 'Baby' ? 'checked' : '' }}> <label for="baby">Baby</label>
                                @else
                                    <input id="male" name="gender" type="radio" value="Male" {{ $sub_table->gender == 'Male' ? 'checked' : '' }}> 
                                    <label for="male">Male</label> 
                                    <input id="female" name="gender" type="radio" value="Female" {{ $sub_table->gender == 'Female' ? 'checked' : '' }}> 
                                    <label for="female">Female</label>
                                @endif
                                    <input id="unisex" name="gender" type="radio" value="Unisex" {{ $sub_table->gender == 'Unisex' ? 'checked' : '' }}> 
                                    <label for="unisex">Unisex</label>
                                </div>
                            </div>
                        </div>
                    @endif
                
                @endif

                <!-- Description -->
                    <div class="col-lg-7 col-md-7">
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>   
                            <textarea rows="6" cols="50" name="description"  id="description" class="form-control">{{$ad->description}}
                            </textarea>  
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        </div>
                    </div>

                @if($ad->ad_types->slug != 'to-buy' && $ad->ad_types->slug != 'to-rent')
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
                                    <label for="price" class="control-label">{{$Price}}</label> 
                                    <input placeholder="Price (Rs)" step="any" name="price" type="number" value="{{$ad->price}}" id="price" class="form-control">
                                </div>
                                @if( ($ad->categories->slug) == 'land' && $ad->ad_types->slug == 'for-sale')
                                <!-- Price Unit -->
                                <div class="col-lg-4">
                                    <label for="priceUnit" class="control-label">Unit</label>
                                    <div class="control-label">
                                        <select id="priceUnit" name="priceUnit" class="form-control">
                                            <option value="total price" {{ $sub_table->price_unit == 'total price' ? 'selected' : '' }} >total price</option>
                                            <option value="per perch" {{ $sub_table->price_unit == 'per perch' ? 'selected' : '' }} >per perch</option>
                                            <option value="per acre" {{ $sub_table->price_unit == 'per acre' ? 'selected' : '' }} >per acre</option>
                                        </select>
                                    </div>
                                    <span class="text-danger">{{ $errors->first('priceUnit') }}</span>
                                </div>
                                @endif
                                <!-- Negotiable -->                                
                                <div class="col-lg-4">
                                    <input type="checkbox" name="negotiable"  value="Negotiable" 
                                    {{ $ad->negotiable == '1' ? 'checked' : '' }} >
                                    <label for="new" style="margin-top: 38px;">Negotiable</label>
                                </div>
                            </div>
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                        </div>
                    </div>
                @endif

                <!-- CONTACT DETAILS -->

                <div class="col-lg-7 col-md-7">
                    <h4 class="fill-de">Contact details</h4>
                    <hr>
                </div>
    
                <!-- Contact Name -->
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <label for="contact_name" class="control-label">Contact Name</label> 
                        <input type="text" name="contact_name" value="{{Auth::user()->name}}" class="form-control" readonly>
                    </div>
                </div>

                <!-- Contact Numbers -->
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <div class="phone-no-box">
                            <p class="pno-title">Phone number(s)</p>
                            <div class="e_phone-numbers">
                                @if ($ad->user_phones->count() > 0)
                                    <?php $i = 0; ?>
                                    @foreach($ad->user_phones as $user_phone)
                                        <?php $i++; ?>
                                        <p class="p-no e_p-no-<?php echo $i; ?>">
                                            <input type="text" name="e_phone_number[]" value="{{ $user_phone->mobile_number }}" class="phone-nums" readonly>
                                            <a href="javascript:void(0);" id='e_phone-remove-<?php echo $i; ?>' class="e_phone-remove">
                                                <i class="fa fa-minus-circle e_remove-num" aria-hidden="true"></i>
                                            </a>
                                        </p>
                                    @endforeach
                                @endif
                                <?php $pnCount = count($ad->user_phones); ?>
                                <input type="hidden" name="e_phone_count" id="e_phone_count" value="{{$pnCount}}">
                            </div>
                            
                            <span id ="e_pno-message" style="color: red;"></span>
                            <a href="javascript:void(0);" id="e_sbmtPhone" style="display: none;">Add this number</a><br/>
                            
                            @if($pnCount == 0)
                            <div class="e_pno-add" id="e_dp">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='e_addPhone' class="e_addPhone"> Add a phone number</a>
                            </div>
                            @else
                            <div class="e_pno-add" id="e_dp">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='e_addPhone' class="e_addPhone"> Add another phone number</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ./CONTACT DETAILS -->                

                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {{form::hidden('_method', 'PUT')}}
                        {{form::submit('Edit Ad', ['class' => 'btn btn-primary'])}}
                    </div>
                </div>

            {!! Form::close() !!}
        
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
        
@endsection