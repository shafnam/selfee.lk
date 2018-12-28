@extends('layouts.app')

@section ('title') Classifieds on selfee.lk @endsection

@section('content')
    <!-- Page Content -->
    
            @include('inc.messages')

            @include('inc.search-form')

            <div class="row white-bg">
                
                @include('inc.sidebar')

                <div class="col-md-7 s-result">
                
                    <!--  breadcrumbs-->
                    <div class="row">
                        <div class="col-md-12 res-top">
                            <p>
                                <a href="{{ url('/') }}">Home</a> 
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="{{ url('ads') }}">All ads</a>
                                @if(isset($locationParentName)) <i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="{{ url('ads/location/'.$location_parent_slug) }}">{{ $locationParentName }}</a> @endif
                                @if(isset($locationName)) @if(isset($categoryName))<i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="{{ url('ads/location/'.$location_slug) }}">{{ $locationName }} </a> @else <b>{{ $locationName }}</b> @endif @endif
                                @if(isset($categoryParentName)) <i class="fa fa-long-arrow-right" aria-hidden="true"></i><a href="{{ url('ads/category/'.$category_parent_slug) }}">{{ $categoryParentName }}</a> @endif
                                @if(isset($categoryName))<i class="fa fa-long-arrow-right" aria-hidden="true"></i><b>{{$categoryName}}</b>@endif
                            </p>
                            <p><b>Showing: {{ $ads->firstItem() }} - {{$ads->lastItem()}} of {{ $ads->total() }} ads</b></p>
                        </div>
                    </div>
                    <!-- /.breadcrumbs-->
                    
                    <!-- Ads Display Starts Here-->
                    @if(count($ads) > 0)
                        @foreach($ads as $ad)
                        <?php $path = 'uploads'; $string = "\\"; ?>
                            <div class="row add-box">
                                <div class="col-md-4">
                                    <img src="{{ asset('ad-photos/'.$ad->ad_photos->first()->title) }}" class="img-fluid" alt="Responsive image">
                                </div>
                                <div class="col-md-8">
                                    <a href="{{ url('ads/'.$ad->slug ) }}">{{$ad->title}}</a>
                                    <p class="add-time"><i class="fa fa-clock-o" aria-hidden="true"></i> 
                                        {{date('d M g:i a', strtotime($ad->created_at))}}
                                    </p>
                                    <p class="add-loca"><i class="fa fa-map-marker" aria-hidden="true"></i> 
                                        {{$ad->locations->name}}, {{$ad->categories->name}}
                                    </p>
                                    @if(isset($ad->price))
                                    <p class="add-price">Rs {{$ad->price}}</p>
                                    @endif
                                    <p class="add-details">type: {{$ad->type_id}}</p>
                                    @if(isset($ad->electronics_ads->condition))
                                    <p class="add-details">cond:  {{$ad->electronics_ads->condition}}</p>
                                    @endif
                                    @if(isset($ad->electronics_ads->brand))
                                    <p class="add-details">brand: {{$ad->electronics_ads->brand}}</p>
                                    @endif
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
                    
                </div>

            </div>
        
@endsection
