@extends('layouts.app')

@section ('title') Choose Category @endsection

@section('content')
    
    <!-- Page Content -->
    <div class="row white-bg add-cat">
        
            <div class="col-lg-12 add-cat-topic">
            <?php if($ad_type == 'for-sale'){ ?>
                    <h3>Sell an item or service</h3>
            <?php } else if($ad_type == 'for-rent'){ ?>
                    <h3>Offer a property for rent</h3>
            <?php } else if($ad_type == 'to-rent'){ ?>
                    <h3>Look for property to rent</h3>
            <?php } else if($ad_type == 'to-buy'){ ?>
                    <h3>Look for something to buy</h3>
            <?php } ?>
                    <hr>
            </div>

        <div class="col-md-12 td-box2">
            <div class="row">
                    <div class="col-lg-12 col-md-12">
                        
                        <div class="row">
                            
                            <div class="col-lg-4 col-md-6">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    
                                    <h4><i class="fa fa-caret-right" aria-hidden="true"></i> Select a category</h4>
                                    
                                    @foreach($allSubCategories as $subCats)
                                    <?php 
                                        $has_children = \App\Category::hasChildCategory($subCats->id);
                                        if($has_children) {
                                    ?>
                                        <a class="nav-link" id="{{ $subCats->slug }}-tab" data-toggle="pill" href="#{{ $subCats->slug }}" role="tab" aria-controls="{{ $subCats->slug }}" aria-selected="true">
                                            @if(isset($subCats->icon))
                                            <img src="{{ asset('web-photos/'.$subCats->icon) }}" class="img-fluid" width="18" alt="Responsive image">
                                            @endif
                                            {{ $subCats->name }}
                                            <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    <?php } else { ?>
                                        <a class="nav-link" href="{{ url('ads/post-ad/'.$ad_type.'/'.$type.'/'.$subCats->parent_id.'/'.$subCats->slug ) }}">
                                            @if(isset($subCats->icon))
                                            <img src="{{ asset('web-photos/'.$subCats->icon) }}" class="img-fluid" width="18" alt="Responsive image">
                                            @endif
                                            {{ $subCats->name }}
                                            <span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    <?php } ?>
                                    @endforeach
                                    
                                </div>
                            </div>
                                
                            <div class="col-lg-5 col-md-6">
                                <div class="tab-content" id="v-pills-tabContent">
                                    
                                        @foreach($allSubCategories as $subCats)   
                                        <div class="tab-pane fade" id="{{ $subCats->slug }}" role="tabpanel" aria-labelledby="{{ $subCats->slug }}-tab">
                                            <h4>Select a sub category...</h4>
                                            <ul>
                                                @foreach($subCats->subCategory as $firstNestedSub)
                                                <?php if($firstNestedSub->name != 'Portions & Rooms' && $firstNestedSub->name != 'Holiday & Short-Term Rental'){ ?>
                                                    <li><a href="{{ url('ads/post-ad/'.$ad_type.'/'.$type.'/'.$firstNestedSub->parent_id.'/'.$firstNestedSub->slug ) }}">{{ $firstNestedSub->name }}<span class="r-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                                                <?php } ?>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endforeach
                                   
                                </div>
                            </div>

                        </div>
                        
                    </div>
            </div>
        </div>
        <div class="col-md-12 td-box">
            <p><i class="fa fa-caret-right" aria-hidden="true"></i> Location</p>
            <p><i class="fa fa-caret-right" aria-hidden="true"></i> Details</p>
        </div>
    </div>
    
    <!-- Page Content -->
          
@endsection
