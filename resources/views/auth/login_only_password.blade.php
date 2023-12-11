@extends('layouts.auth')

@section('content')
<div class="az-signin-wrapper">
    <div class="az-card-signin">
      <div class="az-signin-header">
        <h2>{{__('app.label_welcome')}}</h2>
        <h4>{{__('app.label_info_sign_in')}}</h4>

        <form  method="POST" action="{{ route('login') }}">
            @csrf
          <div class="form-group​​ has-danger">
            <input type="hidden" class="form-control" name="email" placeholder="{{ __('app.label_user_email') }}" value="{{ $user->email }}">
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
