@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <?php
        $ad_parent_category_details = \App\Category::getParentCategoryByCategoryId($ad->category_id);
        $ad_parent_category_slug = $ad_parent_category_details->slug;
    ?>
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                <?php 
                    if($ad->status == 0){
                ?>
                <li class="breadcrumb-item"><a href="{{ route('administrator.new.ads.list') }}">New Ads</a></li>
                <?php } else {?>
                <li class="breadcrumb-item"><a href="{{ route('administrator.published.ads.list') }}">Published Ads</a></li>
                <?php }?>
                <li class="breadcrumb-item active" aria-current="page">View</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        @if(session()->has('success_messge'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session()->get('success_messge') }}</li>
                </ul>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>{{$ad->title}}</h4>
                <p>
                    <?php 
                        if(($ad->ad_types->slug) == 'to-rent' || ($ad->ad_types->slug) == 'to-buy'){
                            echo 'Wanted ';
                        }
                    ?>
                    {{$ad->ad_types->name}} 
                    by {{$ad->customers->name}} <i class="fa fa-clock-o" aria-hidden="true"></i> {{date('Y M d g:i a', strtotime($ad->created_at))}} <i class="fa fa-map-marker" aria-hidden="true"></i> 
                    {{$ad->locations->name}}
                </p>
            </div>
            <div class="panel-body">
                <div class="row adz-photo">
                    @if($ad->type_id != '5')
                    <div class="col-md-6">
                        <div class="row">
                            @foreach($ad->ad_photos as $ad_photo)
                            <div class="col-md-4">
                                <img src="{{ asset('ad-photos/'.$ad_photo->title) }}" style="max-width: 600px; width: 100%;"> 
                            </div>     
                            @endforeach
                        </div>
                    </div> 
                    @endif       
                    
                    <div class="col-md-6 more-detail">
                        @if($ad_parent_category_slug == 'electronics')
                            @if(isset($ad->electronics_ads->condition))
                            <p><b>Condition:</b> {{$ad->electronics_ads->condition}}</p>
                            @endif
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

                        @if(isset($ad->price))
                        <?php $price = str_replace(".00", "", (string)number_format ($ad->price, 2)); ?>
                            <p>
                                <b>Price:</b> Rs {{$price}}
                                @if(isset($ad->properties_ads->land_size))
                                    {{$ad->properties_ads->price_unit}}
                                @endif
                                @if($ad->negotiable == '1')
                                    <b>(Negotiable)</b>
                                @endif
                            </p>                         
                        @endif
                        
                        <p>
                            <b>Description:</b> 
                            {!! nl2br(e($ad->description)) !!}
                        </p>

                        <p>
                            <b>Contact Number(s):</b>
                            @foreach($ad->user_phones as $user_phone)
                                - {{$user_phone->mobile_number}} 
                            @endforeach
                        </p>

                        <?php if($ad->status == 0) { ?>
                        <form action="{{ route('administrator.ads.approve.post',[$ad->id]) }}" method="post" style="float: left; margin: 10px 10px 10px 0;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="ad_id" name="ad_id" value="{{ $ad->id }}">
                            <button class="btn btn-success" id="ad_approve_btn">Approve this Ad</button>                                
                        </form>
                        <a href="{{ route('administrator.ads.reject.get',[$ad->id]) }}" class="btn btn-danger" style="float: left; margin: 10px 10px 10px 0;">Reject this Ad</a>
                        
                        <?php } ?>
                    </div>
                </div>
                       
            </div>
        </div>
    </div>
@stop