<!--<div class="container-fluid home-top">-->
    <div class="container">
        <div class="row">
            
            <div class="col-md-7 c-left pt-5  pb-5">
                
                <h1>Welcome to Selfee.lk - <br/>The largest marketplace in Sri Lanka!</h1>
                <p>Buy and sell everything from used cars to mobile phones and computers, or search for property, jobs and more in Sri Lanka!</p>

                <h4>Browse our Top Categories:</h4>
                <div class="row top-cat-bar">
                    
                    @foreach($topCategories as $topCategory)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ asset('web-photos/'.$topCategory->icon) }}" class="img-fluid com-img" width="36" alt="{{$topCategory->name}}">
                            <a href="{{ url('ads/category/'.$topCategory->slug) }}">{{$topCategory->name}}</a>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>

            <div class="col-md-5 top-main-box pb-5">
                <div class="row topic-bar">
                    <h1>Browse by Location:</h1> 
                </div>
                <div class="row location-box">
                    @foreach($parentLocations as $parentLocation)
                    <div class="col-md-4">
                        <div class="card box-one">
                            <div class="card-body">
                                <ul>
                                    <li><a href="{{ url('ads/location/'.$parentLocation->slug )}}"><i class="fa fa-location-arrow" aria-hidden="true"></i> {{$parentLocation->name}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
<!--</div>  -->