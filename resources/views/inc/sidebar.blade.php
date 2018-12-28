<div class="col-md-3 s-option">
    <?php 
        $url = 'ads/';
        if(isset($category_slug)){
            $url = 'ads/category/'.$category_slug;
        }
        if(isset($location_slug)){
            $url = 'ads/location/'.$location_slug;
        }
        if(isset($category_slug) && isset($location_slug)){
            $url = 'ads/location/'.$location_slug.'/category/'.$category_slug;
        }
    ?>
    
    {!! Form::open(['name' => 'filterAdsByAttributes', 'url' => $url, 'method' => 'GET', 'id'=> 'filterAdsByAttributes']) !!}
    
    <h5>Sort result by:</h5>
    <hr>

    <div class="form-group box-end">
        <select name="orderAds" class="form-control" id="exampleFormControlSelect1" onChange="this.form.submit();">
            <option value="date_desc" <?php if(!isset($orderAds) || $orderAds=='date_desc'){echo "selected";} ?>>Date: Newest on top</option>
            <option value="date_asc" <?php if(isset($orderAds) && $orderAds=='date_asc'){echo "selected";} ?>>Date: Oldest on top</option>
            <option value="price_desc" <?php if(isset($orderAds) && $orderAds=='price_desc'){echo "selected";} ?>>Price: High to Low</option>
            <option value="price_asc" <?php if(isset($orderAds) && $orderAds=='price_asc'){echo "selected";} ?>>Price: Low to High</option>
        </select>
    </div>

    <h5>Category :</h5>
    <hr>
    <p>
        <?php 
            $url = 'ads/';
            if(isset($location_slug)){$url = 'ads/location/'.$location_slug;} 
        ?>
            <a href="{{ url($url) }}">All Categories</a>
    </p>

    <ul class="category-list mb-4">
        @foreach($categories as $category)
            <?php
                $url = 'ads/category/'.$category->slug;
                if(isset($location_slug)){ $url = 'ads/location/'.$location_slug.'/category/'.$category->slug; }
                else{ $location_id = null; }
            ?>
            @if($category->childrenads->count() > 0)
            <li class="<?php echo (isset($category_slug))? ($category_slug == $category->slug)?'active':'hide':''; echo (isset($category_parent_slug))? ($category_parent_slug == $category->slug)?'active':'':'' ?>">
                <a href="{{ url($url) }}" class="<?php echo (isset($category_slug))? ($category_slug == $category->slug)?'active':'':''; echo (isset($category_parent_slug))? ($category_parent_slug == $category->slug)?'active':'':'' ?>">
                    {{$category->name}}
                </a>
                <?php if(!isset($category_slug)){ ?>
                    <span class="add-count">(<?php echo $category->childrenads->count(); ?>)</span>
                <?php } ?>
                <ul class="sub-menu">
                    @foreach($category->children as $sCat)
                        <?php
                            $url = 'ads/category/'.$sCat->slug;
                            if(isset($location_slug)){ $url = 'ads/location/'.$location_slug.'/category/'.$sCat->slug; }
                            else{ $location_id = null; }
                            if(!isset($ad_type_id)){ $ad_type_id = null; }
                            if(!isset($min_price)){ $min_price = null; }
                            else{ if($min_price === '0') {$min_price = null;} }
                            if(!isset($max_price)){ $max_price = null; }
                            else{ if($max_price === '999999999999999999') {$max_price = null;} }
                            if(!isset($ad_cond)){ $ad_cond = null; }
                            if(!isset($ad_brand_id)){ $ad_brand_id = null; }
                            $url = $url. '?' .http_build_query(['orderAds' => 'date_desc', 'ad_type' => $ad_type_id,'price_min' => $min_price,'price_max' => $max_price, 'ad_condition' => $ad_cond, 'ad_brand' => $ad_brand_id]);
                        ?>     
                        @if($sCat->ads->count() > 0)
                        <li class="<?php echo (isset($category_slug))? ($category_slug == $sCat->slug)?'active':'':'';?>">
                            <a href="{{ url($url) }}" class="<?php echo (isset($category_slug))? ($category_slug == $sCat->slug)?'active':'':'';?>">
                                {{$sCat->name}}
                            </a>
                            <?php //if(!isset($category_parent_slug)){ ?>
                                <span class="add-count">(<?php echo $sCat->ads->count(); ?>)</span>
                            <?php //} ?>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endif
        @endforeach
    </ul>    

    <h5>Location :</h5>
    <hr>
    <p>
        <?php 
            $url = 'ads/';
            if(isset($category_slug)){$url = 'ads/category/'.$category_slug;}
        ?>
            <a href="{{ url($url) }}">All Locations</a>
    </p>

    <ul class="location-list mb-4">
        @foreach($locations as $location)
            <?php
                $url = 'ads/location/'.$location->slug;
                if(isset($category_slug)){ $url = 'ads/location/'.$location->slug.'/category/'.$category_slug;}
                else{ $category_id = null; }
                if(!isset($ad_type_id)){ $ad_type_id = null; }
                if(!isset($min_price)){ $min_price = null; }
                else{ if($min_price === '0') {$min_price = null;} }
                if(!isset($max_price)){ $max_price = null; }
                else{ if($max_price === '999999999999999999') {$max_price = null;} }
                if(!isset($ad_cond)){ $ad_cond = null; }
                if(!isset($ad_brand_id)){ $ad_brand_id = null; }
                $url = $url. '?' .http_build_query(['orderAds' => 'date_desc', 'ad_type' => $ad_type_id,'price_min' => $min_price,'price_max' => $max_price, 'ad_condition' => $ad_cond, 'ad_brand' => $ad_brand_id]);
            ?>
            @if($location->childrenads->count() > 0)
            <li class="<?php echo (isset($location_slug))? ($location_slug == $location->slug)?'active':'hide':''; echo (isset($location_parent_slug))? ($location_parent_slug == $location->slug) ? 'active':'':'' ?>">
                <a href="{{ url($url) }}" class="<?php echo (isset($location_slug))? ($location_slug == $location->slug)?'active':'':''; echo (isset($location_parent_slug))? ($location_parent_slug == $location->slug) ? 'active':'':'' ?>">
                    {{$location->name}}
                </a>
                <?php if(!isset($location_slug)){ ?>
                <span class="add-count">({{ $location->childrenads->count() }})</span>
                <?php } ?>
                <ul class="sub-menu">
                    @foreach($location->children as $subLoc)
                        <?php
                            $url = 'ads/location/'.$subLoc->slug;
                            if(isset($category_slug)){ $url = 'ads/location/'.$subLoc->slug.'/category/'.$category_slug;}
                            else{ $category_id = null;}
                            if(!isset($ad_type_id)){ $ad_type_id = null; }
                            if(!isset($min_price)){ $min_price = null; }
                            else{ if($min_price === '0') {$min_price = null;} }
                            if(!isset($max_price)){ $max_price = null; }
                            else{ if($max_price === '999999999999999999') {$max_price = null;} }
                            if(!isset($ad_cond)){ $ad_cond = null; }
                            if(!isset($ad_brand_id)){ $ad_brand_id = null; }
                            $url = $url. '?' .http_build_query(['orderAds' => 'date_desc', 'ad_type' => $ad_type_id,'price_min' => $min_price,'price_max' => $max_price, 'ad_condition' => $ad_cond, 'ad_brand' => $ad_brand_id]);
                        ?>
                        @if($subLoc->ads->count() > 0)
                        <li class="<?php echo (isset($location_slug))? ($location_slug == $subLoc->slug)?'active':'':'';?>">
                            <a href="{{ url($url) }}" class="<?php echo (isset($location_slug))? ($location_slug == $subLoc->slug)?'active':'':'';?>">
                                {{$subLoc->name}}
                            </a>
                            <?php if(!isset($location_parent_slug)){ ?>
                            <span class="add-count">({{ $subLoc->ads->count() }})</span>
                            <?php } ?>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endif
        @endforeach
        <?php if(!isset($location_parent_slug)){ ?>
        <div id="loadMore">Load more</div>
        <?php } ?>
    </ul>

    @if(isset($category_parent_slug))
    <!--  Ad type -->
    <h5>Type of ad :</h5>
    <hr>
    <div class="col-lg-12 col-md-12">
    
        @foreach($ad_types as $ad_type)
            <div class="form-group">
                @if($ad_type->ads->count() > 0)
                <input onChange="this.form.submit();" class="radio" type="radio" name="ad_type" id="{{$ad_type->slug}}" value="{{$ad_type->id}}"
                <?php echo (isset($ad_type_id))? ($ad_type_id == $ad_type->id)?'checked="checked"':'':''; ?> />
                <?php if(($ad_type->slug) == 'to-rent' || ($ad_type->slug) == 'to-buy'){ echo 'Wanted -'; } ?>
                {{$ad_type->name}} ({{ $ad_type->ads->count() }})
                @endif                
            </div>
        @endforeach

    </div>

    <div class="col-lg-12 col-md-12 other-filters">
        <div class="accordion" id="sidebar-accordion">
            <!-- Condition -->
            
            <?php if($ad_type_id != 5){ ?>
                <!-- Price -->
                <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle font-weight-bold" data-toggle="collapse" href="#priceFilter">
                                Price (Rs)
                                <i aria-hidden="true" class="fa fa-angle-down"></i>
                            </a>
                            <hr>
                        </div>
                        <div id="priceFilter" class="accordion-body collapse">
                            <div class="accordion-inner">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::text('price_min', '', ['id' => 'price_min', 'class' => 'form-control', 'placeholder' => 'min' ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            {!! Form::text('price_max', '', ['id' => 'price_max', 'class' => 'form-control', 'placeholder' => 'max' ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 mb-3">
                                        {!! Form::submit( 'Apply filters', ['class' => 'btn btn-default', 'name' => 'filterPrice', 'value' => 'filterPrice']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <br/>
                <!-- Brand -->
                
            <?php } ?>

        </div>
    </div>
    @endif

    
    {!! Form::close() !!}

</div>