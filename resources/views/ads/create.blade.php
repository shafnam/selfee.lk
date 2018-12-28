@extends('layouts.app')

@section ('title') Posting ad on selfee.lk @endsection

@section('content')

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
        
        {!! Form::open(['name' => 'uploadFile', 'action' => 'AdsController@store', 'method' => 'POST', 'id'=> 'ad-upload-form', 'enctype' => 'multipart/form-data']) !!}
            
            <!-- Ad type id & name -->
            <input type="hidden" name="ad_type_id" value="{{$getAdTypeDetails->id}}">
            <input type="hidden" name="ad_type" value="{{$getAdTypeDetails->slug}}">
            
            <!-- Category-->
            <div class="col-lg-7 col-md-7 cat-sec">
                <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                Category: {{$getCatParentDetails->name}} 
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
                <?php if(strpos($getCatDetails->name , '_fs') !== false) { 
                    $getCatDetails->name  = str_replace('_fs', '', $getCatDetails->name);
                ?>
                    {{$getCatDetails->name}}
                <?php } else { ?>
                    {{$getCatDetails->name}}
                <?php } ?>
                <input type="hidden" name="parent_category" value="{{$getCatParentDetails->slug}}">
                <input type="hidden" name="category" value="{{$getCatDetails->slug}}">
                <input type="hidden" name="category_id" value="{{$getCatDetails->id}}">
                <span class="r-change"><a href="/ads/post-ad/{{$getAdTypeDetails->slug}}/{{$type}}">Change</a></span>
                <hr>
            </div>
        
            <!-- Location-->
            <div class="col-lg-7 col-md-7 cat-sec" style="margin-top: 0px;">
                <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                Location: {{$getLocParentDetails->name}} 
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i> 
                {{$getLocDetails->name}}
                <input type="hidden" name="location_id" value="{{$getLocDetails->id}}">
                <span class="r-change"><a href="/ads/post-ad/{{$getAdTypeDetails->slug}}/{{$type}}/{{$getCatDetails->parent_id}}/{{$getCatDetails->slug}}">Change</a></span>
                <hr>
            </div>

            <!-- Ad photos-->
            @if($getAdTypeDetails->slug != 'to-buy' && $getAdTypeDetails->slug != 'to-rent')
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
                        <span class="text-danger">{{ $errors->first('file_upload') }}</span>
                    </div>
                </div>
            </div>
            @endif
            <!-- ./Ad photos-->

            <!-- AD DETAILS -->

            <div class="col-lg-7 col-md-7">
                <h4 class="fill-de">Fill in the details</h4>
                <hr>
            </div>

            <!-- Title -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Your ad\'s name' ]) !!}
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>
            </div>
            
            @if($getAdTypeDetails->slug != 'to-buy' && $getAdTypeDetails->slug != 'to-rent')
            <!-- These fields are not available for 'to buy'  and 'to rent' category -->
            
            <!-- Condition -->
                @if(($getCatDetails->slug) != 'auto-services' 
                && ($getCatParentDetails->slug) != 'property' && ($getCatDetails->slug) != 'sports-supplements' 
                && ($getCatDetails->slug) != 'licences-titles' && ($getCatDetails->slug) != 'other-business-services' 
                && ($getCatParentDetails->slug) != 'services' && ($getCatDetails->slug) != 'higher-education'
                && ($getCatDetails->slug) != 'tuition' && ($getCatDetails->slug) != 'vocational-institutes'
                && ($getCatDetails->slug) != 'other-education' && ($getCatDetails->slug) != 'pets' 
                && ($getCatDetails->slug) != 'pet-food' && ($getCatDetails->slug) != 'veterinary-services' 
                && ($getCatDetails->slug) != 'farm-animals' && ($getCatDetails->slug) != 'other-animals' 
                && ($getCatParentDetails->slug) != 'food-agriculture' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('condition', 'Condition', ['class' => 'control-label']) !!}
                        <div class="control-label"> 
                            {!! Form::radio('condition', 'New', true, ['id' => 'new']) !!}
                            {!! Form::label('new', 'New') !!}
                            {!! Form::radio('condition', 'Used', false, ['id' => 'used']) !!}
                            {!! Form::label('used', 'Used') !!}
                            @if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'auto-parts-accessories' ||
                            ($getCatDetails->slug) == 'boats-water-transport' )
                            {!! Form::radio('condition', 'Reconditioned', false, ['id' => 'reconditioned']) !!}
                            {!! Form::label('reconditioned', 'Reconditioned') !!}
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            
            <!-- Type -->
                @if( ($getCatDetails->slug) == 'computers-tablets' || ($getCatDetails->slug) == 'computer-accessories' || ($getCatDetails->slug) == 'tv-video-accessories'
                || ($getCatDetails->slug) == 'cameras-camcorders' || ($getCatDetails->slug) == 'audio-mp3' 
                || ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'heavy-machinery-tractors' || ($getCatDetails->slug) == 'auto-services'
                || ($getCatDetails->slug) == 'auto-parts-accessories' || ($getCatDetails->slug) == 'land' || ($getCatDetails->slug) == 'commercial-property'
                || ($getCatDetails->slug) == 'furniture' || ($getCatDetails->slug) == 'health-beauty-products' || ($getCatDetails->slug) == 'musical-instruments'
                || ($getCatDetails->slug) == 'sports-equipment' || ($getCatDetails->slug) == 'travel-events-tickets' || ($getCatDetails->slug) == 'music-books-movies' 
                || ($getCatDetails->slug) == 'childrens-items' || ($getCatDetails->slug) == 'other-business-services' || ($getCatParentDetails->slug) == 'services' 
                || ($getCatDetails->slug) == 'textbooks' || ($getCatDetails->slug) == 'tuition' || ($getCatDetails->slug) == 'pets' || ($getCatDetails->slug) == 'farm-animals'
                || ($getCatDetails->slug) == 'food' || ($getCatDetails->slug) == 'portions-rooms' || ($getCatDetails->slug) == 'holiday-short-term-rental')
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
                        {!! Form::label('type', $AdType, ['class' => 'control-label'] )  !!}                
                        <div class="control-label">
                            @if(($getCatDetails->slug) == 'cars')
                            {!! Form::select('type', $getBodyTypes, null, ['class' => 'form-control']) !!}
                            @else
                            {!! Form::select('type', $getTypes, null, ['class' => 'form-control']) !!}
                            @endif
                        </div>
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                    </div>
                </div>
                @endif

            <!-- Brand -->
                @if( ($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'computers-tablets' || ($getCatDetails->slug) == 'tvs'
                || ($getCatDetails->slug) == 'cameras-camcorders' || ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' 
                || ($getCatDetails->slug) == 'vans-buses-lorries' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('brand', 'Brand', ['class' => 'control-label'] )  !!}                
                        <div class="control-label">
                            {!! Form::select('brand', $getBrands, null, ['class' => 'form-control']) !!}
                        </div>
                        <span class="text-danger">{{ $errors->first('brand') }}</span>
                    </div>
                </div>
                @endif

            <!-- Model -->
                @if( ($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'computers-tablets' || ($getCatDetails->slug) == 'tvs'
                || ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters'
                || ($getCatDetails->slug) == 'vans-buses-lorries' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('model', 'Model') !!}
                        {!! Form::text('model', '', ['class' => 'form-control', 'placeholder' => 'Model']) !!}
                        <span class="text-danger">{{ $errors->first('model') }}</span>
                    </div>
                </div>
                @endif

            <!-- Model Year-->
                @if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' || ($getCatDetails->slug) == 'three-wheelers' 
                || ($getCatDetails->slug) == 'vans-buses-lorries' || ($getCatDetails->slug) == 'heavy-machinery-tractors')
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('modelYear', 'Model Year') !!}
                        {!! Form::number('modelYear', '', ['class' => 'form-control', 'placeholder' => 'Model Year','step'=>'any']) !!}
                        <span class="text-danger">{{ $errors->first('modelYear') }}</span>
                    </div>
                </div>
                @endif

            <!-- Mileage (km)-->
                @if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' || ($getCatDetails->slug) == 'three-wheelers'
                || ($getCatDetails->slug) == 'vans-buses-lorries' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('mileage', 'Mileage (km)') !!}
                        {!! Form::number('mileage', '', ['class' => 'form-control', 'placeholder' => 'Mileage (km)','step'=>'any']) !!}
                        <span class="text-danger">{{ $errors->first('mileage') }}</span>
                    </div>
                </div>
                @endif

            <!-- Transmission -->
                @if( ($getCatDetails->slug) == 'cars' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('transmission', 'Transmission', ['class' => 'control-label'] )  !!}                
                        <div class="control-label">
                            {!! Form::select('transmission', $getTranmissions, null, ['class' => 'form-control']) !!}
                        </div>
                        <span class="text-danger">{{ $errors->first('transmission') }}</span>
                    </div>
                </div>
                @endif

            <!-- Fuel Type -->
                @if( ($getCatDetails->slug) == 'cars' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('fuelType', 'Fuel Type', ['class' => 'control-label']) !!}
                        <div class="control-label"> 
                            {!! Form::radio('fuelType', 'Diesel', true, ['id' => 'diesel']) !!}
                            {!! Form::label('diesel', 'Diesel') !!}
                            {!! Form::radio('fuelType', 'Petrol', false, ['id' => 'petrol']) !!}
                            {!! Form::label('petrol', 'Petrol') !!}
                            {!! Form::radio('fuelType', 'CNG', false, ['id' => 'cng']) !!}
                            {!! Form::label('cng', 'CNG') !!}
                            {!! Form::radio('fuelType', 'Other', false, ['id' => 'other']) !!}
                            {!! Form::label('other', 'Other') !!}
                        </div>
                    </div>
                </div>
                @endif

            <!-- Engine capacity (cc)-->
                @if( ($getCatDetails->slug) == 'cars' || ($getCatDetails->slug) == 'motorbikes-scooters' || ($getCatDetails->slug) == 'vans-buses-lorries' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('engineCapacity', 'Engine capacity (cc)') !!}
                        {!! Form::number('engineCapacity', '', ['class' => 'form-control', 'placeholder' => 'Engine capacity (cc)','step'=>'any']) !!}
                        <span class="text-danger">{{ $errors->first('engineCapacity') }}</span>
                    </div>
                </div>
                @endif

            <!-- Authenticity -->
                @if(($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'watches')
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('authenticity', 'Authenticity', ['class' => 'control-label']) !!}
                        <div class="control-label"> 
                            {!! Form::radio('authenticity', 'Original', true, ['id' => 'original']) !!}
                            {!! Form::label('original', 'Original') !!}
                            {!! Form::radio('authenticity', 'Replica', false, ['id' => 'replica']) !!}
                            {!! Form::label('replica', 'Replica') !!}
                        </div>
                    </div>
                </div>
                @endif

            <!-- Features -->
                @if(($getCatDetails->slug) == 'mobile-phones' || ($getCatDetails->slug) == 'portions-rooms')
                <div class="col-lg-7 col-md-7">
                    <!-- Checkboxes -->
                    <div class="form-group">
                        {!! Form::label('features', 'Features (optional)', ['class' => 'control-label']) !!}
                        <div class="control-label">
                            @foreach($getFeatures as $getFeature) 
                                {!! Form::checkbox('features[]', $getFeature) !!} {{$getFeature}}
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            <!-- Bedrooms & Bathrooms-->
                @if( ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'portions-rooms'
                || ($getCatDetails->slug) == 'holiday-short-term-rental')
                <!-- Bedrooms-->
                <div class="col-lg-7 col-md-7">
                    {!! Form::label('bedrooms', 'Bedrooms', ['class' => 'control-label'] )  !!}                
                    <div class="control-label">
                        {!! Form::select('bedrooms', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '10+' => '10+'], null, ['class' => 'form-control', 'placeholder' => 'Select...']) !!}
                    </div>
                    <span class="text-danger">{{ $errors->first('bedrooms') }}</span>
                </div>
                <!-- Bathrooms-->
                <div class="col-lg-7 col-md-7">
                    {!! Form::label('bathrooms', 'Bathrooms', ['class' => 'control-label'] )  !!}                
                    <div class="control-label">
                        {!! Form::select('bathrooms', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '10+' => '10+'], null, ['class' => 'form-control', 'placeholder' => 'Select...']) !!}
                    </div>
                    <span class="text-danger">{{ $errors->first('bathrooms') }}</span>
                </div>
                @endif

            <!-- Land Size -->
                @if( ($getCatDetails->slug) == 'land' || ($getCatDetails->slug) == 'houses')
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-8 col-md-6">
                                {!! Form::label('landSize', 'Land Size') !!}
                                {!! Form::number('landSize', '', ['class' => 'form-control', 'placeholder' => 'Land Size','step'=>'any']) !!}
                                <span class="text-danger">{{ $errors->first('landSize') }}</span>
                            </div>
                            <!-- Unit -->
                            <div class="col-lg-4 col-md-6">
                                {!! Form::label('landUnit', 'Land Unit', ['class' => 'control-label'] )  !!}                
                                <div class="control-label">
                                    {!! Form::select('landUnit', ['perches' => 'perches', 'acres' => 'acres'], 'perches', ['class' => 'form-control']) !!}
                                </div>
                                <span class="text-danger">{{ $errors->first('landUnit') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            <!--  Size -->
                @if( ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'commercial-property'
                || ($getCatDetails->slug) == 'shoes-footwear' )
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        <?php 
                            if(($getCatDetails->slug) == 'houses'){ $Size = 'House Size'; $placeholder = 'Size (sqft)'; }
                            else if(($getCatDetails->slug) == 'commercial-property'){ $Size = 'Property Size'; $placeholder = 'Size (sqft)'; }
                            else if(($getCatDetails->slug) == 'shoes-footwear'){ $Size = 'Size'; $placeholder = 'Size (optional)'; }
                            else{ $Size = 'Size'; $placeholder = 'Size'; } 
                        ?>
                        {!! Form::label('size', $Size) !!}
                        {!! Form::number('size', '', ['class' => 'form-control', 'placeholder' => $placeholder,'step'=>'any']) !!}
                        <span class="text-danger">{{ $errors->first('size') }}</span>
                    </div>
                </div>
                @endif

            <!-- Address -->
                @if( ($getCatDetails->slug) == 'land' || ($getCatDetails->slug) == 'houses' || ($getCatDetails->slug) == 'apartments' || ($getCatDetails->slug) == 'commercial-property'
                || ($getCatDetails->slug) == 'portions-rooms' || ($getCatDetails->slug) == 'holiday-short-term-rental')
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('address', 'Address (optional)') !!}
                        {!! Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address' ]) !!}
                        <span class="text-danger">{{ $errors->first('address') }}</span>
                    </div>
                </div>
                @endif

            <!-- Gender -->
                @if( ($getCatDetails->slug) == 'clothing' || ($getCatDetails->slug) == 'shoes-footwear' || ($getCatDetails->slug) == 'childrens-items')
                <div class="col-lg-7 col-md-7">
                    <div class="form-group">
                        {!! Form::label('gender', 'Gender (optional)', ['class' => 'control-label']) !!}
                        <div class="control-label"> 
                            @if(($getCatDetails->slug) == 'childrens-items')
                                {!! Form::radio('gender', 'Boys', false, ['id' => 'boys']) !!}
                                {!! Form::label('boys', 'Boys') !!}
                                {!! Form::radio('gender', 'Girls', false, ['id' => 'girls']) !!}
                                {!! Form::label('girls', 'Girls') !!}
                                {!! Form::radio('gender', 'Baby', false, ['id' => 'baby']) !!}
                                {!! Form::label('baby', 'Baby') !!}
                            @else
                                {!! Form::radio('gender', 'Male', false, ['id' => 'male']) !!}
                                {!! Form::label('male', 'Male') !!}
                                {!! Form::radio('gender', 'Female', false, ['id' => 'female']) !!}
                                {!! Form::label('female', 'Female') !!}
                            @endif
                            {!! Form::radio('gender', 'Unisex', false, ['id' => 'unisex']) !!}
                            {!! Form::label('unisex', 'Unisex') !!}
                        </div>
                    </div>
                </div>
                @endif
            @endif

            <!-- Description -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Ad description here...', 'rows' => 6]) !!}
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                </div>
            </div>

            @if($getAdTypeDetails->slug != 'to-buy' && $getAdTypeDetails->slug != 'to-rent')
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
                            {!! Form::label('price', $Price) !!}
                            {!! Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Price (Rs)','step'=>'any']) !!}
                        </div>
                        @if( ($getCatDetails->slug) == 'land' && $getAdTypeDetails->slug == 'for-sale')
                        <!-- Price Unit -->
                        <div class="col-lg-4">
                            {!! Form::label('priceUnit', 'Unit', ['class' => 'control-label'] )  !!}                
                            <div class="control-label">
                                {!! Form::select('priceUnit', ['total price' => 'total price', 'per perch' => 'per perch', 'per acre' => 'per acre'], 'total price', ['class' => 'form-control']) !!}
                            </div>
                            <span class="text-danger">{{ $errors->first('priceUnit') }}</span>
                        </div>
                        @endif
                        <div class="col-lg-4">
                            {!! Form::label(' ', '', ['style' => 'height: 50px'] )  !!} 
                            {!! Form::checkbox('negotiable', 'Negotiable') !!} Negotiable
                        </div>
                    </div>
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                </div>
            </div>
            @endif

            <!-- ./AD DETAILS -->

            <!-- CONTACT DETAILS -->

            <div class="col-lg-7 col-md-7">
                <h4 class="fill-de">Contact details</h4>
                <hr>
            </div>

            <!-- Contact Name -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    {!! Form::label('contactName', 'Contact Name') !!}
                    {!! Form::text('contactName', Auth::user()->name, ['class' => 'form-control','readonly']) !!}
                </div>
            </div>

            <!-- Contact Numbers -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    <div class="phone-no-box">
                        <p class="pno-title">Phone number(s)</p>
                        <div class="phone-numbers">
                        @if(count($getPhones) > 0)
                            <?php $i = 0; ?>
                            @foreach($getPhones as $getPhone) 
                                <?php $i++; ?>
                                <p class="p-no p-no-<?php echo $i; ?>">
                                    {!! Form::text('phone_number[]', $getPhone, ['class' => 'phone-nums', 'readonly']) !!}
                                    <a href="javascript:void(0);" id='phone-remove-<?php echo $i; ?>' class="phone-remove">
                                        <i class="fa fa-minus-circle remove-num" aria-hidden="true"></i>
                                    </a>
                                </p>
                            @endforeach
                        @endif
                            <?php $pnCount = count($getPhones); ?>
                            <input type="hidden" name="phone_count" id="phone_count" value="{{$pnCount}}">
                        </div>
                        
                        <span id ="pno-message" style="color: red;"></span>
                        <a href="javascript:void(0);" id="sbmtPhone" style="display: none;">Add this number</a><br/>
                        
                        @if($pnCount == 0)
                        <div class="pno-add" id="dp">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='addPhone' class="addPhone"> Add a phone number</a>
                        </div>
                        @else
                        <div class="pno-add" id="dp">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i><a href="javascript:void(0);" id='addPhone' class="addPhone"> Add another phone number</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    {!! Form::label('contactEmail', 'Email') !!}
                    {!! Form::email('contactEmail', Auth::user()->email, ['class' => 'form-control','readonly']) !!}
                </div>
            </div>

            <!-- ./CONTACT DETAILS -->
            
            <div class="col-lg-7 col-md-7">
                <div class="form-group">
                    {{form::submit('Post Ad', ['class' => 'btn btn-primary'])}}
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
        
@endsection