<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <!-- Font Awesome-->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{asset('css/business-frontpage.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/lightslider.css')}}">
    <link rel="stylesheet" href="{{asset('css/side-bar.css')}}">
</head>

<body>
    <div id="app">
        @include('inc.navbar')
        <!-- Show only on Home page -->
        @if(Request::is('/'))
            @include('inc.home-banner')
        @endif
        <!-- /.Show only on Home page -->
        @yield('breadcrumbs')
        <div class="container-fluid b-section inner-page" @if(Request::is('/')) style="border-top: 2px solid #e07f0a;"@endif>
            <div class="container" @if(Request::is('/')) style="margin-top: 60px; box-shadow: 0 3px 4px 1px #d5e1e6; border-radius: 5px;"@endif>
                @yield('content')
            </div>
        </div>
    </div>
    @include('inc.footer')
    
</body>
</html>
