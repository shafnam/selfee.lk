<?php ini_set('max_ecxecution_time', 180); ?>
@extends('layouts.app')

@section ('title') Reset Password | selfee.lk @endsection

@section('content')
<div class="row white-bg login-box" style="margin: 7rem;">     

    <div class="col-md-12 log-right">        
        <h3 class="text-center mb-4">Reset Password</h3>
        
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success text-center mb-4">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <!--<div class="col-md-12">
            <div class="alert alert-success col-md-12 text-center mb-4">
                We have e-mailed your password reset link!
            </div>
        </div>-->    

        <div class="row">    

            <form class="form-horizontal log-form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}               

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Email" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-dark signup-btn com-row">
                            Send Password Reset Link
                        </button>
                    </div>
                </div>
            </form>            

        </div>
    
    </div>
</div>

@endsection
