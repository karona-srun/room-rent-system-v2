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
                            <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="az-content-label mg-b-5 mb-1">{{ __('app.menu_user') }}</div>
                                <hr>
                                <div class="row mb-2">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="">
                                            <label class="form-label text-center"
                                                for="basic-icon-default-company">{{ __('app.label_user_image') }}</label>
                                            <div class="mt-2 justify-center items-center text-center">
                                                <img class="card-img-top card-id rounded card-photo-back imagePreviewBack img-image"
                                                    src="{{ asset('assets/img/faces/user.gif') }}"
                                                    alt="Card image cap">
                                                <input type="file"
                                                    accept="image/png, image/gif, image/jpeg, image/jpg"
                                                    name="image" id="photo_back" class="imageUploadBack"
                                                    style="display: none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_user_name') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="name" value="{{ $user->name }}"
                                                    placeholder="{{ __('app.label_user_name') }}" type="text">
                                                @error('name')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_user_email') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="email"
                                                    placeholder="{{ __('app.label_user_email') }}" value="{{$user->email}}" type="email">
                                                @error('email')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 mb-2">
                                                <label class="form-label">{{ __('app.label_user_phone') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="phone"
                                                    value="{{ $user->phone }}"
                                                    placeholder="{{ __('app.label_user_phone') }}" />
                                                    @error('phone')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <label class="form-label">{{ __('app.label_apartment') }} <span
                                                        class="tx-danger">*</span></label>
                                                <select class="form-control select2 room" name="apartment">
                                                    <option value="">{{ __('app.label_choose') }}</option>
                                                    @foreach ($apartment as $apart)
                                                        <option value="{{ $apart->id }}"
                                                            data-price="{{ $apart->name }}" {{ $apart->id == $user->apartment_id ? 'selected' : ''}}>
                                                            {{ $apart->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('apartment')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                            <div class="col-sm-4 mb-2">
                                                <label class="form-label">{{ __('app.label_status') }} </label>
                                                <select class="form-control select2-no-search" name="is_active">
                                                    <option value="1" {{ 1 == $user->is_active ? 'selected' : ''}}>{{ __('app.label_user_active') }}</option>
                                                    <option value="0" {{ 0 == $user->is_active ? 'selected' : ''}}>{{ __('app.label_user_inactive') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_password') }}</label>
                                                <input class="form-control" name="password" 
                                                    placeholder="{{ __('app.label_password') }}" type="password" autocomplete="new-password">
                                                @error('password')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_confirm_password') }}</label>
                                                <input class="form-control" name="password_confirmation" autocomplete="new-password"
                                                    placeholder="{{ __('app.label_confirm_password') }}" type="password">
                                                @error('password')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
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
