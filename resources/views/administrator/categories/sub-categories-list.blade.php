@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content')
    <div class="col-md-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('administrator.dashboard') }}">Home</a> </li>
                <li class="breadcrumb-item"><a href="{{ route('administrator.category.list') }}">All Categories</a></li>
                @if(isset($sub_category_main))
                    <?php $breadcrumb = \App\Category::setBreadcrumbs($sub_category_main->parent_id); ?>
                    @for($i = count($breadcrumb)-1;$i >= 0; $i--)
                      @if($i == count($breadcrumb)-1)
                           <li class="breadcrumb-item"><a href="{{ route('administrator.category.list.id',[$breadcrumb[$i][0]]) }}">{{ $breadcrumb[$i][1] }}</a> </li>
                      @else
                           <li class="breadcrumb-item"><a href="{{ route('administrator.sub-sub-category.list',[$breadcrumb[$i][0]]) }}">{{ $breadcrumb[$i][1] }}</a> </li>
                      @endif
                    @endfor
                    <li class="breadcrumb-item active" aria-current="page">{{ $sub_category_main->name }}</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">All Sub Categories</li>
                @endif

            </ol>
        </nav>
    </div>
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>@if(isset($sub_category_main)) Sub Category :: {{ $sub_category_main->name }}
                        <span class="pull-right" style="margin-top: -5px">
                            <a href="{{ route('administrator.sub-sub-category.add.get',[$sub_category_main->id]) }}" class="btn btn-default">Add New</a>
                        </span>
                    @else
                        All Sub Categories
                        <span class="pull-right" style="margin-top: -5px">
                            <a href="{{ route('administrator.sub-category.add.get') }}" class="btn btn-default">Add New</a>
                        </span>
                    @endif

                </h4>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="get_sub_location_table" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Sub Category Name</th>
                        <th>Sub Category Slug</th>
                        <th>Parent Category Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_sub_category as $asc)
                        <tr>
                            <td>{{ $asc->name }}</td>
                            <td>{{ $asc->slug }}</td>
                            <td>
                                <?php $parent_category = \App\Category::getParentCategory($asc->parent_id) ?>
                                <span class="badge bg-yellow"><a href="{{ route('administrator.category.list.id',[$parent_category->id]) }}" style="color: #ffffff">{{ $parent_category->name }}</a> </span>
                            </td>
                            <td>
                                <a href="{{ route('administrator.sub-category.edit.get',[$asc->id]) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('administrator.sub-sub-category.add.get',[$asc->id]) }}" class="btn btn-success">Add New Sub Category</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop