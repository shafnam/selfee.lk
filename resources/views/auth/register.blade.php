@extends('layouts.app')

@section('content')
<div class="row white-bg login-box">
    <!--<div class="col-md-6 log-left">
        <h3>Login</h3>
        <p>Login to post your ad and keep track of it in your account.</p>
        <ul>
            <li><img src="images/d1.png" class="img-fluid d-img" alt="Responsive image"> Start posting your own ads.</li>
            <li><img src="images/d2.png" class="img-fluid d-img" alt="Responsive image"> Mark ads as favorite and view them later.</li>
            <li><img src="images/d3.png" class="img-fluid d-img" alt="Responsive image"> View and manage your ads at your convenience.</li>
        </ul>
    </div>-->
    <div class="col-md-12 log-right">
        <!--<div class="row">
            <button type="button" class="btn btn-primary fb-login-btn com-row">
                <i class="fa fa-facebook-official" aria-hidden="true"></i> Continue with facebook</button>
            <p class="text-or">or</p>
        </div>-->
        <h3 class="text-center mb-4">Signup</h3>
        <div class="row">
            <form class="form-horizontal log-form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row acc-box">
            <div class="col-md-12">
                <hr>
            </div>
            <p>Already have an account?</p>
            <a href="/login" class="btn btn-light login-btn com-row">Login</a>
        </div>

    </div>
</div>
@endsection
