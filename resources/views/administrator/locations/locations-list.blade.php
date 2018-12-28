@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                @if(!isset($location))
                    <li class="breadcrumb-item active" aria-current="page">All Locations</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ route('administrator.location.list') }}">All Locations</a> </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $location->name }}</li>
                @endif

            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                    @if(!isset($location))
                        All Locations
                        <span class="pull-right" style="margin-top: -5px">
                            <a href="{{ route('administrator.location.add.get') }}" class="btn btn-default">Add New</a>
                        </span>
                    @else
                        All Locations :: {{ $location->name }}
                        <span class="pull-right" style="margin-top: -5px">
                            <a href="{{ route('administrator.sub-location.add.get.id',[$location->id]) }}" class="btn btn-default">Add New</a>
                        </span>
                    @endif
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Location Name</th>
                        <th>Location Slug</th>
                        @if(!isset($location))
                            <th>Sub Locations</th>
                        @endif

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_locations as $al)
                        <tr>
                            <td>{{ $al->name }}</td>
                            <td>{{ $al->slug }}</td>
                            @if(!isset($location))
                                <td>
                                    <?php $sub_locations = \App\Location::getSubLocations($al->id);?>
                                    @foreach($sub_locations as $sl)
                                        <span class="badge bg-yellow">{{ $sl->name }}</span>
                                    @endforeach
                                </td>
                            @endif
                            <td>
                                <a href="{{ route('administrator.location.edit.get',[$al->id]) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('administrator.sub-location.add.get.id',[$al->id]) }}" class="btn btn-success">Add New Sub Location</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop