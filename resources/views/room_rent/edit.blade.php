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
                                    <div class="az-content-label mg-b-5">{{ __('app.label_room_rent') }}</div>
                                    <p class="mg-b-20">{{ __('app.label_create_room_info') }}</p>
                                </div>
                                <div class="pd-1"><a href="{{ url('room-rent') }}"​
                                        class="btn btn-az-secondary">{{ __('app.label_list') }}{{__('app.label_room_rent')}}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{ url('room-rent', $data->id ) }}" method="post">
                                @csrf
                                @method('patch')
                                <div class="az-content-label mg-b-5 mb-1">{{__('app.label_room_info')}}</div>
                                <hr>
                                <div class="row mb-2">
                                    <div class="col-sm-6 mb-2">
                                        <label class="form-label">{{ __('app.label_room') }} <span
                                                class="tx-danger">*</span></label>
                                            <select class="form-control select2 room" name="room">
                                                @foreach ($rooms as $room)
                                                    <option value="{{ $room->id }}" {{ strval($data->room_id) == strval($room->id) ?  'selected' : ''}} data-price="{{ $room->price }}">{{ $room->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                            @enderror
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label class="form-label">{{ __('app.label_price') }} <span
                                                class="tx-danger">*</span></label>
                                        <input class="form-control price" name="price" step="any" value="{{ $data->price }}" placeholder=""
                                            type="number">
                                        @error('price')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="az-content-label mg-b-5 mb-1">{{__('app.label_customer_fill')}}</div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <label class="form-label">{{ __('app.label_customer_name') }} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="customer_name" value="{{ $data->customer_name }}" />
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <label class="form-label">{{ __('app.label_phone') }} <span class="tx-danger">*</span></label>
                                        <input class="form-control" name="phone" value="{{$data->phone}}"/>
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <label class="form-label">{{ __('app.label_telegram') }} <label class=" typcn typcn-arrow-maximise"></label> {{__('app.btn_disconnect')}}</label>
                                        <select class="form-control select2" name="telegram_id">
                                            <option value="">{{ __('app.label_choose') }}</option>
                                            @foreach ($listGroups as $value => $group)
                                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2 mb-2">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <label class="card-title">{{__('app.label_card_id')}}</label>
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-center text-center">
                                                    <div class="col-auto mb-3">
                                                        <label class="form-label"
                                                            for="basic-icon-default-company">{{ __('app.label_photo_front') }}</label>
                                                        <div class="card mt-2">
                                                            <img class="card-img-top card-id rounded card-photo-front imagePreviewFront"
                                                                src="{{ asset('assets/img/card/front.png') }}" alt="Card image cap">
                                                            <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg"
                                                                name="photo_front" id="photo_front" class="imageUploadFront"
                                                                style="display: none">
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <label class="form-label"
                                                            for="basic-icon-default-company">{{ __('app.label_photo_back') }}</label>
                                                        <div class="card mt-2">
                                                            <img class="card-img-top card-id rounded card-photo-back imagePreviewBack"
                                                                src="{{ asset('assets/img/card/back.png') }}" alt="Card image cap">
                                                            <input type="file" accept="image/png, image/gif, image/jpeg, image/jpg"
                                                                name="photo_back" id="photo_back" class="imageUploadBack"
                                                                style="display: none">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <label class="form-label">{{ __('app.label_address') }}</label>
                                        <textarea class="form-control" name="address">{{$data->address}}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <label class="form-label">{{ __('app.label_noted') }}</label>
                                        <textarea class="form-control" name="noted">{{$data->noted}}</textarea>
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
