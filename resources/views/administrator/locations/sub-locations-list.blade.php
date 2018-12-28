@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{ route('administrator.location.list') }}">All Locations</a> </li>
                <li class="breadcrumb-item active" aria-current="page">All Sub Locations</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>All Locations
                    <span class="pull-right" style="margin-top: -5px"><a href="{{ route('administrator.sub-location.add.get') }}" class="btn btn-default">Add New</a></span>
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_sub_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Sub Location Name</th>
                        <th>Sub Location Slug</th>
                        <th>Parent Locations Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_sub_locations as $asl)
                        <tr>
                            <td>{{ $asl->name }}</td>
                            <td>{{ $asl->slug }}</td>
                            <td>
                                <?php $parent_location = \App\Location::getParentLocation($asl->parent_id) ?>
                                <span class="badge bg-yellow"><a href="{{ route('administrator.location.list.id',[$parent_location->id]) }}" style="color: #ffffff">{{ $parent_location->name }}</a> </span>
                            </td>
                            <td>
                                <a href="{{ route('administrator.sub-location.edit.get',[$asl->id]) }}" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop