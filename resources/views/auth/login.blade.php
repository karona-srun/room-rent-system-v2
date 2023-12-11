@extends('layouts.auth')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="az-signin-wrapper">
    <div class="az-card-signin">
      <div class="az-signin-header">
        <h2>{{__('app.label_welcome')}}</h2>
        <h4>{{__('app.label_info_sign_in')}}</h4>

        <form  method="POST" action="{{ route('login') }}">
            @csrf
          <div class="form-group​​ has-danger">
            <label>{{ __('app.label_email')}}</label>
            <input type="text" class="form-control" name="email" placeholder="{{ __('app.label_user_email') }}" value="">
            @error('email')
                <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false"><li class="parsley-required">{{ $message }}</li></ul>
            @enderror
          </div>
          <div class="form-group mt-3">
            <label>{{ __('app.label_password')}}</label>
            <input type="password" name="password" class="form-control" placeholder="{{__('app.label_password')}}" value="">
            @error('password')
                <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false"><li class="parsley-required">{{ $message }}</li></ul>
            @enderror
          </div>
          <div class="form-group mt-3">
            <label class="ckbox">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span>{{ __('app.label_remember_me') }}</span>
              </label>
          </div>
          <button type="submit" class="btn btn-az-primary btn-block">{{__('app.label_sign_in')}}</button>
        </form>
      </div>
      <div class="az-signin-footer mt-3">
        @if (Route::has('register'))
        <p><a href="{{ route('password.request') }}">Forgot password?</a></p>
       
        <p>Don't have an account? <a href="page-signup.html">Create an Account</a></p>
        @endif
      </div>
    </div>
  </div>
@endsection
