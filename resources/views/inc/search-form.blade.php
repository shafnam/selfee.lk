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
<div class="row search-row sr-box">
    <div class="col-md-12">
        {!! Form::open(['name' => 'searchAds', 'url' => $url, 'method' => 'GET', 'id'=> 'search-ads-form']) !!}
        <div class="row">
            
            <div class="form-group col-md-4">
                <select class="form-control form-control-sm" name="searchLoc" onchange="javascript:location.href = this.value;">
                    <option value="">Search by Location</option>                        
                    @foreach($locations as $location)
                    <?php 
                    $optUrl = '/ads/location/'.$location->slug;
                    if(isset($category_slug)){
                        $optUrl = '/ads/location/'.$location->slug.'/category/'.$category_slug;
                    }
                    ?>
                    <option value="{{$optUrl}}" <?php if(isset($location_slug) && $location_slug==$location->slug){echo "selected";} ?>>{{$location->name}}</option>                    
                    @endforeach
                </select>
            </div>

            <!--<select id="selectbox" name="" onchange="javascript:location.href = this.value;">
                <option value="https://www.yahoo.com/" selected>Option1</option>
                <option value="https://www.google.co.in/">Option2</option>
                <option value="https://www.gmail.com/">Option3</option>
            
            </select>-->

            <div class="form-group col-md-4">
                <select class="form-control form-control-sm" name="searchCat" onchange="javascript:location.href = this.value;">
                    <option value="">Search by Category</option>                        
                    @foreach($categories as $category)
                    <?php 
                    $optUrl = '/ads/category/'.$category->slug;
                    if(isset($location_slug)){
                        $optUrl = '/ads/location/'.$location_slug.'/category/'.$category->slug;
                    }
                    ?>
                    <option value="/ads/category/{{$category->slug}}" <?php if(isset($category_slug) && $category_slug==$category->slug){echo "selected";} ?>>{{$category->name}}</option>                    
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" placeholder="What are you searching for?" name="searchTerm">
                    <span class="input-group-addon hserch-icon">
                        <button type="submit" class="btn btn-dark btn-sm serch-btn">Search</button>
                    </span>
                </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>