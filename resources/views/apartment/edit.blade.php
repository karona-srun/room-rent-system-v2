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
                                    <div class="az-content-label mg-b-5">{{ __('app.label_apartment_info') }}</div>
                                    <p class="mg-b-20">{{ __('app.label_create_apartment_info') }}</p>
                                </div>
                                <div class="pd-1"><a href="{{ url('apartment') }}"​
                                        class="btn btn-az-secondary">{{ __('app.label_apartment_info') }}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{ url('apartment', $apart->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <label class="form-label text-center"
                                            for="basic-icon-default-company">{{ __('app.label_user_image') }}</label>
                                        <div class="mt-2 justify-center items-center text-center">
                                            <img class="card-img-top card-id rounded card-photo-back imagePreviewBack img-image"
                                                src="{{ asset($apart->logo == '' ? 'assets/img/apartment.png' : 'assets/img/' . $apart->logo) }}"
                                                alt="Card image cap">
                                            <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg"
                                                name="logo" id="photo_back" class="imageUploadBack"
                                                style="display: none">
                                        </div>
                                        @error('logo')
                                            <ul class="parsley-errors-list filled text-center" id="parsley-id-5"
                                                aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="col-md-9 col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12 mb-3">
                                                <label class="form-label">{{ __('app.label_apartment') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="name" placeholder="" type="text"
                                                    value="{{ $apart->name }}">
                                                @error('name')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-2">
                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.trash_cost') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="trash_cost" step="any"
                                                    value="{{ $apart->trash_cost }}" placeholder="" type="number">
                                                @error('trash_cost')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <label class="form-label">{{ __('app.label_exchange_riel') }} <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" name="exchange_riel" step="any"
                                                    value="{{ $apart->exchange_riel }}" placeholder="" type="number">
                                                @error('exchange_riel')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">{{ $message }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-2">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">{{ __('app.label_water_module') }}</div>
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6 mb-2">
                                                                <label
                                                                    class="form-label">{{ __('app.label_water_module') }}</label>
                                                                <select name="water_module" id=""
                                                                    class=" form-select select2">
                                                                    <option value="0">
                                                                        {{ __('app.label_water_module_on') }}</option>
                                                                    <option value="1">
                                                                        {{ __('app.label_water_module_off') }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label class="form-label">{{ __('app.label_water_cost') }}
                                                                    <span class="tx-danger">*</span></label>
                                                                <input class="form-control" name="water_cost" step="any"
                                                                    value="{{ $apart->water_cost }}" placeholder=""
                                                                    type="number">
                                                                @error('water_cost')
                                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                                        aria-hidden="false">
                                                                        <li class="parsley-required">{{ $message }}</li>
                                                                    </ul>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3 mt-2">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">{{ __('app.label_date_info') }}</div>
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6 mb-2">
                                                                <label
                                                                    class="form-label">{{ __('app.label_apart_start_date') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="start_date" value="{{ $apart->start_date }}" />
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label
                                                                    class="form-label">{{ __('app.label_apart_end_date') }}</label>
                                                                <input type="number" class="form-control"
                                                                    name="end_date" value="{{ $apart->end_date }}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-2">
                                                                <label
                                                                    class="form-label">{{ __('app.label_terms_and_conditions') }}</label>
                                                                <textarea class="form-control" rows="3" name="terms_and_conditions">{{ $apart->terms_and_conditions }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12 mb-2">
                                                <label class="form-label">{{ __('app.label_telegram_key') }}</label>
                                                <input class="form-control" name="token" value="{{ $apart->token }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3 mt-2">
                                            <div class="col-sm-12 mb-2">
                                                <label class="form-label">{{ __('app.label_address') }}</label>
                                                <textarea class="form-control" rows="3" name="address">{{ $apart->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-12 mb-2">
                                                <label class="form-label">{{ __('app.label_noted') }}</label>
                                                <textarea class="form-control" rows="3" name="noted">{{ $apart->noted }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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
