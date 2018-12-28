@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('content_header')
@stop
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
                    <li class="breadcrumb-item active" aria-current="page">Sub Categories</li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
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
                <h4>Add New Sub Catgeory @if(isset($sub_category_main)) :: {{ $sub_category_main->name }} @endif</h4>
            </div>
            <div class="panel-body">
                <form action="{{ route('administrator.sub-category.add.post') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="parent_id" value="{{ $id }}">
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Parent Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="parent_category" id="parent_category" required>
                                    <option value="" selected="true" disabled>Select Parent Category</option>
                                    @foreach($all_category as $ac)
                                        @if($id)
                                            @if($ac->id == $id)
                                                <option value="{{ $ac->id }}" selected="true">{{ $ac->name }}</option>
                                            @endif
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
                            <label>Sub Category Name : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="name" id="category_name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-4">
                            <label>Sub Category Slug : </label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input name="slug" id="category_slug" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <div class="col-md-6 col-md-offset-4" style="text-align: right">
                            <button class="btn btn-primary" id="category_submit_btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop