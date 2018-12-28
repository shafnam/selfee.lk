@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')

    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                @if(isset($category))
                    <li class="breadcrumb-item"><a href="{{ route('administrator.category.list') }}">All Categories</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                @endif
            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>
                    @if(isset($category))
                        Category :: {{ $category->name }}
                    @else
                        All Categories
                        <span class="pull-right" style="margin-top: -5px"><a href="{{ route('administrator.category.add.get') }}" class="btn btn-default">Add New</a></span>
                    @endif

                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_category_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Category Slug</th>
                        <th>Sub Categories</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_category as $ac)
                        <tr>
                            <td>{{ $ac->name }}</td>
                            <td>{{ $ac->slug }}</td>
                            <td>
                                <?php $sub_category = \App\Category::getSubCategories($ac->id);?>
                                @foreach($sub_category as $sc)
                                        <span class="badge bg-yellow"><a href="{{ route('administrator.sub-sub-category.list',[$sc->id])}}" style="color: #ffffff">{{ $sc->name }}</a></span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('administrator.category.edit.get',[$ac->id]) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('administrator.sub-sub-category.add.get',[$ac->id]) }}" class="btn btn-success">Add New Sub Category</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop