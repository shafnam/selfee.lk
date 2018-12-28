@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                @if(isset($brand))
                    <li class="breadcrumb-item"><a href="{{ route('administrator.brands.list') }}">All Brands</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $brand->name }}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">All Brands</li>
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
                <h4>
                    @if(isset($brand))
                        Brand :: {{ $brand->name }}
                    @else
                        All Brands
                        <span class="pull-right" style="margin-top: -5px"><a href="{{ route('administrator.brands.add.get') }}" class="btn btn-default">Add New</a></span>
                    @endif

                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_category_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Brand Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_brands as $ab)
                        <tr>
                            <td>{{ $ab->name }}</td>
                            <td>
                                {{$ab->categories->name}}
                            </td>
                            <td>
                                <a href="{{ route('administrator.brands.edit.get',[$ab->id]) }}" class="btn btn-primary" style="float: left; margin-right: 10px;">Edit</a>
                                <!--Delete Function-->
                                <!--<form action="{{ route('administrator.brands.destroy', $ab->id) }}" method="POST" onsubmit="return confirm('Do you really want to delete?');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>-->
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop