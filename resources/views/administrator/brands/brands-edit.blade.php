@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                @if(isset($brand))
                    <li class="breadcrumb-item"><a href="{{ route('administrator.brands.list',[$brand->id]) }}">{{ $brand->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">Brands</li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                @endif
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
                <h4>Edit - Brand </h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('administrator.brands.edit.post',[$brand->id]) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="brand_id" name="brand_id" value="{{ $brand->id }}">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="category" id="category" required>
                                    <option value="" selected="true" disabled>Select Category</option>
                                    @foreach($all_categories as $ac)
                                        @if($ac->id == $brand->category_id)
                                            <option value="{{ $ac->id }}" selected="true">{{ $ac->name }}</option>
                                        @else
                                            <option value="{{ $ac->id }}">{{ $ac->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Brand Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" id="brand_name" class="form-control" required value="{{ $brand->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="brand_submit_btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop