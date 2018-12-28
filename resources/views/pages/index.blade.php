@extends('layouts.app')

@section ('title') selfee.lk - Electronics, Cars, Property and Jobs in Sri Lanka  @endsection

@section('content')

    <div class="row topic-bar">
        <h1>Browse by Category</h1>   
    </div>

    <div class="row" style="background: white;">

        @foreach($itemServiceCategories as $itemServiceCategory)
        <div class="col-md-3 cat-box">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('web-photos/'.$itemServiceCategory->icon) }}" class="img-fluid com-img" width="36" alt="{{$itemServiceCategory->name}}">
                    <a href="/ads/category/{{$itemServiceCategory->slug}}">{{$itemServiceCategory->name}}</a>
                    <p> ({{$itemServiceCategory->childrenads->count()}}) </p>
                </div> 
            </div>
        </div>
        @endforeach
        
    </div>
        
@endsection
