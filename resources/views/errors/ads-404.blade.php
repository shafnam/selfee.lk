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
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control hs-input" name="username" placeholder="What are you searching for?" aria-label="Username" aria-describedby="basic-addon1">
                    <span class="input-group-addon hserch-icon" id="basic-addon1"> <i class="fa fa-search" aria-hidden="true"></i>  Search</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        @include('inc.sidebar')

        <div class="col-md-7 s-result">
            Page not fond
        </div>
        <div class="col-md-2 s-adz">
            <img src="images/side-banner.jpg" class="img-fluid" alt="Responsive image">
        </div>

    </div>

@endsection
