@extends('layouts.app')

@section ('title') Choose Nearest Area @endsection

@section('content')
    
    <!-- Page Content -->
    <div class="row white-bg add-cat">
        
        <div class="col-md-12 add-cat-topic">
            <h3>Where are you located?</h3>
            <hr>
        </div>

        <div class="col-lg-7 col-md-10 cat-sec">
            <p>
                <i class="fa fa-check-circle-o" aria-hidden="true"></i> 
                Category: {{$getCatParentDetails->name}} <!--get db values -->
                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>

            <?php if(strpos($getCatDetails->name , '_fs') !== false) { 
                $getCatDetails->name  = str_replace('_fs', '', $getCatDetails->name);
            ?>
                {{$getCatDetails->name}}
            <?php } else { ?>
                {{$getCatDetails->name}}
            <?php } ?>

                <span class="r-change">
                    <a href="{{ url('ads/post-ad/'.$ad_type.'/'.$type ) }}">Change</a>
                </span>

            </p>
            <hr>
        </div>
    

        <div class="col-md-12 td-box2">
            <div class="row">
                    <div class="col-lg-12 col-md-12">
                        
                        <div class="row">
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Select a Location</h4>
                                    <p>Districts</p>
                                    @foreach($allSubLocations as $subLoc)
                                        <a class="nav-link" id="{{ $subLoc->slug }}-tab" data-toggle="pill" href="#{{ $subLoc->slug }}" role="tab" aria-controls="{{ $subLoc->slug }}" aria-selected="true">
                                            {{ $subLoc->name }}
                                            <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                                
                            <div class="col-lg-4 col-md-6">
                                <div class="tab-content" id="v-pills-tabContent">                                    
                                    @foreach($allSubLocations as $subLoc)   
                                    <div class="tab-pane fade" id="{{ $subLoc->slug }}" role="tabpanel" aria-labelledby="{{ $subLoc->slug }}-tab">
                                        <h4>Select a local area within {{ $subLoc->location_name }}</h4>
                                        <p>Popular areas</p>
                                        <ul class="all-locations">
                                            @foreach($subLoc->subLocation as $firstNestedSub)
                                            <li><a href="{{ url('ads/post-ad/'.$ad_type.'/'.$type.'/'.$getCatParentDetails->id.'/'.$getCatDetails->slug.'/'.$firstNestedSub->parent_id.'/'.$firstNestedSub->slug ) }}">{{ $firstNestedSub->name }} <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                    <!--<div id="loadMoreLocations">Load more...</div>-->
                                </div>
                            </div>

                        </div>
                        
                    </div>
            </div>
        </div>

        <div class="col-md-12 ml-3 mt-3">
            <p><!--<i class="fa fa-caret-right" aria-hidden="true"></i>-->3. Details</p>
        </div>
    </div>
    
    <!-- Page Content -->
          
@endsection
