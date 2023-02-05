@extends('layouts.master-without-nav')
@section('title') Email @endsection
@section('body')
    <style>
        *{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
            'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        }
        @media only screen and (max-width: 480px) {
            .card-body {
                padding: 0px !important;
            }
            .btn-dark{
                width: 60% !important;
            }
        }
    </style>
    <body>
    @endsection
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body" style="background: #edf2f7; padding: 0px 150px">

                        <h1 style="text-align: center; font-size: 19px;padding: 35px 0px">Raw Gym</h1>
                        <div style="background-color: #fff;padding: 32px">
                            <h1 style="font-size: 18px; margin-bottom: 12px">Hello!</h1>
                            <p style="margin-bottom: 16px">You are receiving this email because we received a password reset request for your
                                account.</p>
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <form method="GET" action="{{ route('reset-password',['token' => $token]) }}">
                                <div class="form-group">
                                    <input type="hidden" name="email" value="{{$email}}">
                                </div>

                                <div class="mt-4" style="text-align: center">
                                    <button class="btn btn-dark btn-block waves-effect waves-light" id="register"
                                            type="submit" formtarget="_blank" style="background-color: #2d3748; border: 1px solid #2d3748;color: #fff;
                                            width: 35%; height: 40px; border-radius: 10px;margin: 20px auto">
                                        {{ __('Reset Password') }}</button>
                                </div>
                            </form>
                            <p style="margin-bottom: 16px">This password reset link will expire in 60 minutes.</p>

                            <p style="margin-bottom: 16px">If you did not request a password reset, no further action is required.</p>

                            <p style="margin-bottom: 16px">Regards,</p>
                            <p style="margin-bottom: 16px">RAW Gym</p>
                        </div>
                        <p style="text-align: center;padding: 35px 0px">© 2022 RAW Gym. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection






{{--@extends('layouts.master-without-nav')--}}

{{--@section('title') Email @endsection--}}

{{--@section('body')--}}

{{--    <body>--}}
{{--    @endsection--}}

{{--    @section('content')--}}

{{--        <div class="home-btn d-none d-sm-block">--}}
{{--            <a href="{{ url('/') }}" class="text-dark"><i class="fas fa-home h2"></i></a>--}}
{{--        </div>--}}
{{--        <div class="account-pages my-5 pt-sm-5">--}}
{{--            <div class="container">--}}
{{--                <div class="row justify-content-center">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="card overflow-hidden">--}}
{{--                            <div class="bg-login text-center">--}}
{{--                                <div class="bg-login-overlay"></div>--}}
{{--                                <div class="position-relative">--}}
{{--                                    <h5 class="text-white font-size-20">Security !</h5>--}}
{{--                                    <p class="text-white-50 mb-0">{{ __('Reset Password') }}</p>--}}
{{--                                    <a href="index" class="logo logo-admin mt-4">--}}
{{--                                        <img src="/images/logo-sm-dark.png" alt="" height="30">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="card-body pt-5">--}}

{{--                                <div class="p-2">--}}
{{--                                    @if (session('status'))--}}
{{--                                        <div class="alert alert-success" role="alert">--}}
{{--                                            {{ session('status') }}--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    <form method="POST" action="{{ route('forgot-password') }}">--}}
{{--                                        @csrf--}}
{{--                                        <div class="form-group">--}}
{{--                                            <label for="useremail">{{ __('E-Mail Address') }}</label>--}}
{{--                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email">--}}
{{--                                            @error('email')--}}
{{--                                            <span class="invalid-feedback" role="alert">--}}
{{--                                            <strong>{{ $message }}</strong>--}}
{{--                                        </span>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="mt-4">--}}
{{--                                            <button class="btn btn-dark btn-block waves-effect waves-light" id="register" type="submit"> {{ __('Send Password Reset Link') }}</button>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="mt-5 text-center">--}}
{{--                            <p>Already have an account ? <a href="/login" class="font-weight-medium text-dark"> Login</a> </p>--}}
{{--                            <p>© <script> document.write(new Date().getFullYear()) </script> RAW Gym. Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="#">CodeX Technologies</a></p>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- JAVASCRIPT -->--}}
{{--        <script src="{{ URL::asset('libs/jquery/jquery.min.js')}}"></script>--}}
{{--        <script src="{{ URL::asset('libs/bootstrap/bootstrap.min.js')}}"></script>--}}
{{--        <script src="{{ URL::asset('libs/metismenu/metismenu.min.js')}}"></script>--}}
{{--        <script src="{{ URL::asset('libs/simplebar/simplebar.min.js')}}"></script>--}}
{{--        <script src="{{ URL::asset('libs/node-waves/node-waves.min.js')}}"></script>--}}

{{--        <script src="{{ URL::asset('js/app.min.js')}}"></script>--}}

{{--@endsection--}}
