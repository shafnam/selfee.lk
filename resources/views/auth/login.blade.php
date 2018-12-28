@extends('layouts.app')

@section ('title') Login | selfee.lk @endsection

@section('content')
<div class="row white-bg login-box">
    <div class="col-md-12 log-right">
        <h3 class="text-center mb-4">Login</h3>
        <div class="row">
            <form class="form-horizontal log-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Email" required autofocus>

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
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Login
                        </button>

                        <p class="text-center">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
        <div class="row acc-box">
            <div class="col-md-12">
                <hr>
            </div>
            <p>Don't have an account yet?</p>
            <a href="/register" class="btn btn-light login-btn com-row">Sign up</a>
        </div>

    </div>
</div>
@endsection
