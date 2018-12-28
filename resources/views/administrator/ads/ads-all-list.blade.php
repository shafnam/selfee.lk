@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                   Published Ads
                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Ad Name</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Poster's name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($get_new_ads as $gna)
                        <tr>
                            <td>{{ $gna->title }}</td>
                            <td>{{ $gna->categories->name }}</td>
                            <td>{{ $gna->locations->name }}</td>
                            <td>{{ $gna->customers->name }}</td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop