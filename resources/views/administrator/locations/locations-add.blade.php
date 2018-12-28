@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('content_header')
@stop
@section('content')
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{ route('administrator.location.list') }}">Location</a> </li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        @if(session()->has('success_messge'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session()->get('success_messge') }}</li>
                </ul>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Add - New Location</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('administrator.location.add.post') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Location Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" id="location_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Location Slug : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="slug" id="location_slug" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="location_submit_btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop