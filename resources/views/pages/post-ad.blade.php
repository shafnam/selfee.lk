@extends('layouts.app')

@section('content')
    
    <!-- Page Content -->
    <h5>Welcome Shafna! Let's post an ad. Choose any option below:</h5>
    <div class="row">
        <div class="col col-lg-6">
            Sell something:
            <ul class="list-group">
                <li class="list-group-item">Sell an item or service</li>
                <li class="list-group-item">Offer a property for rent</li>
                <li class="list-group-item">Post a job vacancy</li>
            </ul>
        </div>
        <div class="col col-lg-6">
            Look for something:
            <ul class="list-group">
                <li class="list-group-item">Look for property to rent</li>
                <li class="list-group-item">Look for something to buy</li>
            </ul>
        </div>
    </div>
    <!-- Page Content -->
          
@endsection
