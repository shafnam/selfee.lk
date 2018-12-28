@extends('layouts.app')

@section ('title') Classifieds on selfee.lk @endsection

@section('content')
    <!-- Page Content -->
    
            @include('inc.messages')
            
            <div class="row search-row">
                <div class="col-md-3">
                    <button type="button" class="btn btn-dark x-btn"><i class="fa fa-map-marker" aria-hidden="true"></i> Select Location</button>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-dark x-btn"><i class="fa fa-tags" aria-hidden="true"></i> Select Category</button>
                </div>
                <!-- Search Box -->
                <div class="col-md-6">
                    
                    {!! Form::open(['name' => 'searchAds', 'url' => 'ads', 'method' => 'GET', 'id'=> 'search-ads-form']) !!}
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control hs-input" name="searchTerm" placeholder="What are you searching for?">
                                <span class="input-group-addon hserch-icon">
                                    <button class="btn btn-default-sm" type="submit">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </span>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    
                </div>
            </div>

            <div class="row">
                
                @include('inc.sidebar')

                <div class="col-md-7 s-result">
                
                    <div class="row">
                        <div class="col-md-12 res-top">
                            <p>
                                <a href="{{ url('/') }}">Home :P</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                <a href="{{ url('ads') }}">All ads</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                @if(isset($locationParentName)) <a href="{{ url('ads/location/'.$location_parent_slug) }}">{{ $locationParentName }}</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>@endif
                                @if(isset($locationName)) @if(isset($categoryName))<a href="{{ url('ads/location/'.$location_slug) }}">{{ $locationName }} </a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>@else <b>{{ $locationName }}</b> @endif @endif
                                @if(isset($categoryParentName)) <a href="{{ url('ads/category/'.$category_parent_slug) }}">{{ $categoryParentName }}</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>@endif
                                @if(isset($categoryName))<b>{{$categoryName}}</b>@endif
                            </p>
                            <p><b>Showing: {{ $ads->firstItem() }} - {{$ads->lastItem()}} of {{ $ads->total() }} ads</b></p>
                        </div>
                    </div>
                    
                    <!-- Ads Display Starts Here-->
                    @if(count($ads) > 0)
                        @foreach($ads as $ad)
                            <div class="row add-box">
                                <div class="col-md-4">
                                    <img src="/storage/ad-photos/{{$ad->ad_photos->first()->title}}" class="img-fluid" alt="Responsive image">
                                </div>
                                <div class="col-md-8">
                                    <a href="{{ url('ads/'.$ad->slug) }}">{{$ad->title}}</a>
                                    <p class="add-time"><i class="fa fa-clock-o" aria-hidden="true"></i> 
                                        {{date('d M g:i a', strtotime($ad->created_at))}}
                                    </p>
                                    <p class="add-loca"><i class="fa fa-map-marker" aria-hidden="true"></i> 
                                        {{$ad->locations->name}}, {{$ad->categories->name}}
                                    </p>
                                    <p class="add-price">Rs {{number_format($ad->price, 2)}}</p>
                                    <p class="add-details">{{$ad->type_id}}</p>
                                    
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Pagination -->
                        <div class="row">
                            <div class="col-md-4 mt-3 mb-3">
                                {{$ads->links()}}
                            </div>
                        </div>
                        <!-- Pagination -->
                        

                    @else
                        <p>No Ads were Found</p>
                    @endif
                </div>

                <div class="col-md-2 s-adz">
                    <img src="images/side-banner.jpg" class="img-fluid" alt="Responsive image">
                </div>

            </div>
        
@endsection
