@extends('layouts.app')

@section ('title') Login | selfee.lk @endsection

@section('content')
<div class="row white-bg login-box">
    
    <div class="col-md-12 log-right">
       
        <h3 class="text-center mb-4">Change password</h3>
        <div class="row">

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <form class="form-horizontal log-form" method="POST" action="{{ route('changePassword') }}">
                
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                    <div class="col-md-6">
                        <input id="current-password" type="password" class="form-control" name="current-password" placeholder="Current password" required>
                        @if ($errors->has('current-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current-password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                    <div class="col-md-6">
                        <input id="new-password" type="password" class="form-control" name="new-password"  placeholder="New password" required>

                        @if ($errors->has('new-password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new-password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" placeholder="Confirm password" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Change Password
                        </button>
                    </div>
                </div>

            </form>           
        </div>
    </div>
</div>
@endsection
