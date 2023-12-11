@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-flex flex-row justify-content-between">
                                <div class="pd-1">
                                    <div class="az-content-label mg-b-5">{{ __('app.label_create_user') }}</div>
                                    <p class="mg-b-20">{{ __('app.label_create_room_info') }}</p>
                                </div>
                                <div class="pd-1"><a href="{{ url('user') }}"​
                                        class="btn btn-az-secondary">{{ __('app.label_list') }}{{ __('app.label_account') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{ url('user/update-password', $user->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="az-content-label mg-b-5 mb-1">{{ __('app.menu_user') }}</div>
                                <hr>
                                <div class="row mb-2">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_password') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="password" 
                                                    placeholder="{{ __('app.label_password') }}" value="{{old('password')}}" type="password" autocomplete="new-password">
                                                @error('password')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_confirm_password') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="password_confirmation" autocomplete="new-password"
                                                    placeholder="{{ __('app.label_confirm_password') }}" type="password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-primary"><i class="typcn typcn-table"></i>
                                            {{ __('app.btn_save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
