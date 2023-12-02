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
                                    <div class="az-content-label mg-b-5">{{ __('app.label_write_message') }}</div>
                                    <p class="mg-b-20">{{ __('app.label_create_room_info') }}</p>
                                </div>
                                <div class="pd-1"><a href="{{ url('message') }}"​
                                        class="btn btn-az-secondary">{{ __('app.label_room_list') }}</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <form action="{{ url('message', $message->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-sm-12 mb-2">
                                        <label class="form-label">{{ __('app.label_choose_room') }} <span
                                                class="tx-danger">*</span></label>
                                                <select class="form-control select_Room" name="room_rent[]" multiple>
                                                    @foreach ($rooms as $item)
                                                        <option value="{{$item->id}}" {{ in_array($item->id,json_decode($message->room_rent_id)) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                        @error('room_rent')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12 mb-2">
                                        <label class="form-label">{{ __('app.label_write_message') }}</label>
                                        <textarea class="form-control" rows="3" name="message">{{ $message->message }}</textarea>
                                        @error('message')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ $message }}</li>
                                            </ul>
                                        @enderror
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
