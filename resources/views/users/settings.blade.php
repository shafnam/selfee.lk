@extends('layouts.app')

@section ('title') Account Settings @endsection

@section('content') 

@include('inc.messages')
<div class="container">
    <div class="row white-bg rules-box myaccount-page">

        <div class="col-md-12 help-box2">
            <div class="row">
                <div class="col-lg-3 col-md-4 help-left">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" href="/dashboard">My account <span class="help-arrow"><i class="fa fa-angle-right fa-lg" aria-hidden="true"></i></span></a>
                        <a class="nav-link active" href="/customers/settings">Settings</a>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 help-right">
                    <div class="tab-content">
                        <div class="tab-pane fade show active about-box set-box">
                            <h3>Settings</h3>
                            <hr>
                            <h4>Change details</h4>
                            <p><span class="set-email-txt">Email:</span>  {{$customer->email}}</p>

                            <div class="update-box">
                                {!! Form::open(['action' => ['CustomersController@update', $customer->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="title">Name</label> 
                                        <input type="text" name="customer_name" value="{{$customer->name}}" id="customer_name" class="form-control">
                                        <span class="text-danger">{{ $errors->first('customer_name') }}</span>
                                    </div>
                                    <!-- Location -->
                                    <div class="form-group">
                                        <label for="Location">Location</label>
                                        <select name="customer_locations" class="form-control" id="customer_locations">
                                            <option>-- Location --</option>
                                            <?php $locations = \App\Location::getAllLocations(); ?>
                                            @foreach($locations as $location)
                                            <option value="{{ $location->name }}" {{ $location->name == $customer->location ? 'selected' : '' }} >
                                                {{ $location->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="Location">Sub Location</label>
                                        <select name="customer_sub_locations" class="form-control">
                                        <?php if(isset($customer->location)){ 
                                            $sub_locations = \App\Location::getSubLocationByParentLocation($customer->location);
                                            foreach($sub_locations as $sub_location){
                                        ?>
                                            <option value="{{ $sub_location->name }}" {{ $sub_location->name == $customer->sub_location ? 'selected' : '' }} >
                                                {{ $sub_location->name }}
                                            </option>
                                        <?php }  } else { ?> 
                                            <option>-- SubLocation --</option>  
                                        <?php } ?>       
                                        </select>                                        
                                    </div>
                                    {{form::hidden('_method', 'PUT')}}
                                    {{form::submit('Update Details', ['class' => 'btn btn-secondary'])}}
                                
                                {!! Form::close() !!}

                            </div>

                            <!--<h4>Change password</h4>-->

                            <div class="update-box">
                                {{-- {!! Form::open(['method' => 'POST']) !!}
                                    <div class="form-group">
                                        <input type="password" name="current_password" class="form-control" placeholder="Current password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="new_password" class="form-control" placeholder="New password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
                                    </div>
                                    {{form::hidden('_method', 'PUT')}}
                                    {{form::submit('Change Password', ['class' => 'btn btn-primary'])}}
                                {!! Form::close() !!} --}}
                            </div>

                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection