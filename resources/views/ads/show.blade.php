@extends('layouts.app')

@section ('title')
    {{$ad->categories->name}} :
    {{$ad->title}} | {{$ad->locations->name}} | selfee
@endsection

@section ('breadcrumbs')
    <div class="container-fluid gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <a href="{{ url('/') }}">Home</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <a href="{{ url('ads') }}">All ads</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- get location parent -->
                        <?php 
                        $loc_parent_details = \App\Location::getSingleLocationParent($ad->locations->parent_id); 
                        if($loc_parent_details){
                        ?>
                        <a href="{{ url('ads/location/'.$loc_parent_details->slug ) }}">{{$loc_parent_details->name}}</a><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <?php } ?>
                        <!-- location -->
                        <a href="{{ url('ads/location/') }}/{{$ad->locations->slug}}">{{$ad->locations->name}}</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- get category parent -->
                        <?php $cat_parent_details = \App\Category::getSingleCategoryParent($ad->categories->parent_id); ?>
                        <a href="{{ url('ads/category/'.$cat_parent_details->slug ) }}">{{$cat_parent_details->name}}</a><i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <!-- category -->
                        <a href="{{ url('ads/category/') }}/{{$ad->categories->slug}}">{{$ad->categories->name}}</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        <em>{{$ad->title}}</em>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

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
                    <h2>{{$ad->title}}</h2>
                    <p><?php 
                        if(($ad->ad_types->slug) == 'to-rent' || ($ad->ad_types->slug) == 'to-buy'){
                            echo 'Wanted ';
                        }
                        ?>
                        {{$ad->ad_types->name}} 
                        by {{$ad->customers->name}} <i class="fa fa-clock-o" aria-hidden="true"></i> {{date('Y M d g:i a', strtotime($ad->created_at))}} <i class="fa fa-map-marker" aria-hidden="true"></i> 
                        {{$ad->locations->name}}
                    </p>
                </div>
            </div>

            @if($ad->type_id != '5')
            <div class="row adz-photo">
                <div class="col-md-7">
                    <div class="item" style="border: 1px solid #efefef; padding: 1rem;">
                        <div class="clearfix" style="max-width: 600px; margin: 0px auto;">
                            <ul id="image-gallery" class="gallery list-unstyled cS-hidden" style="margin: 0 auto;">
                                @foreach($ad->ad_photos as $ad_photo)
                                    <li data-thumb="{{ asset('ad-photos/'.$ad_photo->title) }}">
                                        <img src="{{ asset('ad-photos/'.$ad_photo->title) }}" class="img-fluid" style="margin-right: auto; margin-left: auto; display: block;">
                                    </li>
                                @endforeach
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
                            <h2>Contact</h2>
                            @foreach($ad->user_phones as $user_phone)
                                <h3><span>&#9742;</span>  {{$user_phone->mobile_number}}</h3>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    @if($ad_parent_category_slug == 'electronics')
                        <p><b>Condition:</b> {{$ad->electronics_ads->condition}}</p>
                        @if(isset($ad->electronics_ads->brand))
                            <p><b>Brand:</b> {{$ad->electronics_ads->brand}}</p>
                        @endif
                        @if(isset($ad->electronics_ads->model))
                            <p><b>Model:</b> {{$ad->electronics_ads->model}}</p>
                        @endif
                        @if(isset($ad->electronics_ads->authenticity))
                            <p><b>Authenticity:</b> {{$ad->electronics_ads->authenticity}}</p>
                        @endif
                        @if(isset($ad->electronics_ads->type))
                            <p><b>Type:</b> {{$ad->electronics_ads->type}}</p>
                        @endif
                        @if(count($ad->ad_features)> 0)
                            <p><b>Features:</b>
                                @foreach($ad->ad_features as $ad_feature)
                                    {{$ad_feature->title}},
                                @endforeach
                            </p>
                        @endif
                    @elseif($ad_parent_category_slug == 'cars-vehicles')
                        @if(isset($ad->vehicles_ads->condition))
                            <p><b>Condition:</b> {{$ad->vehicles_ads->condition}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->brand))
                            <p><b>Brand:</b> {{$ad->vehicles_ads->brand}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->model))
                            <p><b>Model:</b> {{$ad->vehicles_ads->model}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->model_year))
                            <p><b>Model Year:</b> {{$ad->vehicles_ads->model_year}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->type))
                            <p><b>Type:</b> {{$ad->vehicles_ads->type}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->transmission))
                            <p><b>Transmission:</b> {{$ad->vehicles_ads->transmission}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->fuel_type))
                            <p><b>Fuel Type:</b> {{$ad->vehicles_ads->fuel_type}}</p>
                        @endif
                        @if(isset($ad->vehicles_ads->engine_capacity))
                            <p><b>Engine Capacity:</b> {{$ad->vehicles_ads->engine_capacity}} CC</p>
                        @endif
                        @if(isset($ad->vehicles_ads->mileage))
                            <p><b>Mileage:</b> {{$ad->vehicles_ads->mileage}} Km</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'property')
                        @if(isset($ad->properties_ads->bedrooms))
                            <p><b>Bedrooms:</b> {{$ad->properties_ads->bedrooms}}</p>
                        @endif
                        @if(isset($ad->properties_ads->bathrooms))
                            <p><b>Bathrooms:</b> {{$ad->properties_ads->bathrooms}}</p>
                        @endif
                        @if(isset($ad->properties_ads->size))
                            <p><b>House Size:</b> {{$ad->properties_ads->size}} sqft</p>
                        @endif
                        @if(isset($ad->properties_ads->type))
                            <p><b>Type:</b> {{$ad->properties_ads->type}}</p>
                        @endif
                        @if(isset($ad->properties_ads->land_size))
                            <p><b>Land Size:</b> {{$ad->properties_ads->land_size}} {{$ad->properties_ads->land_unit}}</p>
                        @endif
                        @if(isset($ad->properties_ads->address))
                            <p><b>Address:</b> {{$ad->properties_ads->address}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'home-garden')
                        @if(isset($ad->home_garden_ads->condition))
                            <p><b>Condition:</b> {{$ad->home_garden_ads->condition}}</p>
                        @endif
                        @if(isset($ad->home_garden_ads->type))
                            <p><b>Type:</b> {{$ad->home_garden_ads->type}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'fashion-health-beauty')
                        @if(isset($ad->health_beauty_ads->condition))
                            <p><b>Condition:</b> {{$ad->health_beauty_ads->condition}}</p>
                        @endif
                        @if(isset($ad->health_beauty_ads->type))
                            <p><b>Type:</b> {{$ad->health_beauty_ads->type}}</p>
                        @endif
                        @if(isset($ad->health_beauty_ads->gender))
                            <p><b>Gender:</b> {{$ad->health_beauty_ads->gender}}</p>
                        @endif
                        @if(isset($ad->health_beauty_ads->size))
                            <p><b>Size:</b> {{$ad->health_beauty_ads->size}}</p>
                        @endif
                        @if(isset($ad->health_beauty_ads->authenticity))
                            <p><b>Authenticity:</b> {{$ad->health_beauty_ads->authenticity}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'hobby-sport-kids')
                        @if(isset($ad->sport_kids_ads->condition))
                            <p><b>Condition:</b> {{$ad->sport_kids_ads->condition}}</p>
                        @endif
                        @if(isset($ad->sport_kids_ads->type))
                            <p><b>Type:</b> {{$ad->sport_kids_ads->type}}</p>
                        @endif
                        @if(isset($ad->sport_kids_ads->gender))
                            <p><b>Gender:</b> {{$ad->sport_kids_ads->gender}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'business-industry')
                        @if(isset($ad->business_industry_ads->condition))
                            <p><b>Condition:</b> {{$ad->business_industry_ads->condition}}</p>
                        @endif
                        @if(isset($ad->business_industry_ads->type))
                            <p><b>Type:</b> {{$ad->business_industry_ads->type}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'services')
                        @if(isset($ad->services_ads->type))
                            <p><b>Type:</b> {{$ad->services_ads->type}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'education')
                        @if(isset($ad->education_ads->condition))
                            <p><b>Condition:</b> {{$ad->education_ads->condition}}</p>
                        @endif
                        @if(isset($ad->education_ads->type))
                        <p><b>Type:</b> {{$ad->education_ads->type}}</p>
                    @endif
                    @elseif($ad_parent_category_slug == 'animals')
                        @if(isset($ad->animals_ads->condition))
                            <p><b>Condition:</b> {{$ad->animals_ads->condition}}</p>
                        @endif
                        @if(isset($ad->animals_ads->type))
                            <p><b>Type:</b> {{$ad->animals_ads->type}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'food-agriculture')
                        @if(isset($ad->food_ads->type))
                            <p><b>Type:</b> {{$ad->food_ads->type}}</p>
                        @endif
                    @elseif($ad_parent_category_slug == 'other')
                        @if(isset($ad->other_ads->condition))
                            <p><b>Condition:</b> {{$ad->other_ads->condition}}</p>
                        @endif
                    @endif
                    <hr>
                </div>
            </div>
            @endif

            <div class="row adz-more-info">
                <!-- Basic ad info -->
                <div class="col-md-9">
                    <p>
                        @if(isset($ad->price))
                        <span class="price">
                            <?php $price = str_replace(".00", "", (string)number_format ($ad->price, 2)); ?>
                            Rs {{$price}}
                            @if(isset($ad->properties_ads->land_size))
                                {{$ad->properties_ads->price_unit}}
                            @endif
                        </span>
                        @endif
                        @if($ad->negotiable == '1')
                            <em>Negotiable</em>
                        @endif
                    </p>

                    <p>{!! nl2br(e($ad->description)) !!}</p>
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
                @foreach($relatedAds as $relatedAd)
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('ad-photos/'.$relatedAd->ad_photos->first()->title) }}" alt="Card image cap">
                        <div class="card-body">
                            <a href="{{ url('ads/'.$relatedAd->slug ) }}">{{$relatedAd->title}}</a>
                            <p class="add-details">{{$relatedAd->price}}</p>
                            <p class="add-loca"><i class="fa fa-map-marker" aria-hidden="true"></i> {{$ad_parent_category_details->name}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Page Content -->
</div>
@endsection
