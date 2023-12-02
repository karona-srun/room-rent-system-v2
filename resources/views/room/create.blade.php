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
                                    <div class="az-content-label mg-b-5">{{ __('app.label_create_room') }}</div>
                                    <p class="mg-b-20">{{ __('app.label_create_room_info') }}</p>
                                </div>
                                <div class="pd-1"><a href="{{ url('room') }}"​
                                        class="btn btn-az-secondary">{{ __('app.label_room_list') }}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{ url('room') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <label class="form-label">{{ __('app.label_room') }} <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" name="name" placeholder="" type="text" value="{{ old('name') }}">
                                        @error('name')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <label class="form-label">{{ __('app.label_price') }} <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control" name="price" step="any" value="{{ old('price') }}" placeholder=""
                                            type="number">
                                        @error('price')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <label class="form-label">{{ __('app.label_status_room') }} <span
                                                class="tx-danger">*</span></label>
                                        <select class="form-control select2-no-search" name="status">
                                            <option value="Free">{{ __('app.status_free') }}</option>
                                            <option value="Rented">{{ __('app.status_rented') }}</option>
                                            <option value="Fixing">{{ __('app.status_fixing') }}</option>
                                        </select>
                                        @error('status')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12 mb-2">
                                        <label class="form-label">{{ __('app.label_noted') }}</label>
                                        <textarea class="form-control" rows="3" name="noted">{{ old('noted')}}</textarea>
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
