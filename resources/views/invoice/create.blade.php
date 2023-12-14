@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="d-flex flex-row justify-content-between">
                                <div class="pd-1">
                                    <div class="az-content-label mg-b-5 h3">
                                        {{__('app.create_invoice')}}
                                    </div>
                                </div>
                                <div class="pd-1"><a href="{{ url('invoice') }}"​ class="btn btn-az-secondary"><i
                                            class="fas fa-arrow-alt-circle-left"></i> {{ __('app.menu_invoice_list') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <form action="{{ url('invoice') }}" method="post">
                                @csrf
                                <input type="hidden" name="saveAndCreate" class="saveAndCreate" value="">
                                <div class="screenshot m-5">
                                    <div class="row mt-3 mb-4">
                                        <div class="col-sm-6 mb-4">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <h3>{{ __('app.invoice') }}</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 mb-4 text-end d-flex flex-row-reverse mg-l-auto">
                                            <div class="input-group text-black" style="justify-content: end;">
                                                {{ __('app.label_day') }}<input type="text"
                                                    class="form-control" name="day"
                                                    value="1">
                                                {{ __('app.label_month') }}<input type="text"
                                                    class="form-control" name="month"
                                                    value="{{ now()->format('m') == 12 ? 1 : now()->format('m') + 1 }}">
                                                {{ __('app.label_year') }}<input type="text"
                                                    class="form-control" name="year"
                                                    value="{{ now()->format('m') == 12 ? now()->format('Y') + 1 : now()->format('Y') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-6 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        {{ __('app.label_room_number') }}
                                                    </div>
                                                </div>
                                                <select class="select-control select2 room" name="room" style="width: -webkit-fill-available">
                                                    <option value="">{{__('app.label_choose_room')}}</option>
                                                    @foreach ($rooms as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-price="{{ $item->price }}"
                                                            class="select-control-custom-option">
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>

                                                
                                            </div>
                                            @error('room_cost')
                                                <ul class="parsley-errors-list filled mx-2 mt-2" id="parsley-id-5"
                                                    aria-hidden="false">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        {{ __('app.room_cost') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control price room_cost text-end"
                                                    name="room_cost" placeholder="0">
                                                <div class="input-group-append">
                                                    <span class="text-black">$</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-lg-12 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        {{ __('app.invoice_eletrotic_cost') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control text-end electric_cost"
                                                    name="electric_cost" placeholder="0" value="0">
                                                <div class="input-group-append">
                                                    <span class="text-black">៛</span>
                                                </div>
                                            </div>
                                            @error('electric_cost')
                                                <ul class="parsley-errors-list filled mx-2 mt-2" id="parsley-id-5"
                                                    aria-hidden="false">
                                                    <li class="parsley-required">{{ $message }}</li>
                                                </ul>
                                            @enderror
                                        </div>
                                        
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-sm-5 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text float-none">
                                                        {{ __('app.invoice_water_cost') }}
                                                    </div>
                                                </div>
                                                <div class="input-group-prepend text-left" style="width: 52px">
                                                    <div class="input-group-text" style="margin-left: -14px !important;">
                                                        {{ __('app.label_new_number') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control new_number" name="new_number"
                                                    placeholder="0" value="{{old('new_number')}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-3 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend me-2" style="width: 82px">
                                                    <div class="input-group-text">
                                                        {{ __('app.label_old_number') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control old_number" name="old_number"
                                                    placeholder="0" value="{{old('old_number')}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control water_cost text-end"
                                                    name="water_cost" placeholder="0" data-value="{{ $apart->water_cost }}" value="0">
                                                <div class="input-group-append">
                                                    <span class="text-black">៛</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-sm-12 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        {{ __('app.trash_cost') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control text-end trash_cost"
                                                    name="trash_cost" placeholder="0" data-exchange="{{ $apart->exchange_riel }}" value="{{ $apart->trash_cost }}">
                                                <div class="input-group-append">
                                                    <span class="text-black">៛</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4 flex-row justify-content-end">
                                        <div class="col-sm-4 mb-3 text-right">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        {{ __('app.label_total_amount') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control text-end sub_total_amount"
                                                    name="sub_total_amount" placeholder="0" value="{{old('sub_total_amount')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-1 flex-row justify-content-end">
                                        <div class="col-sm-4 mb-3 text-right">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control text-end total_amount"
                                                    name="total_amount" placeholder="0" value="{{old('total_amount')}}">
                                            </div>
                                        </div>
                                        @error('sub_total_amount')
                                        <div class="row mb-4 flex-row justify-content-end">
                                            <div class="col-sm-6 mb-3 text-right">
                                            <ul class="parsley-errors-list filled mx-2 mt-2 flex-row justify-content-end" id="parsley-id-5"
                                                aria-hidden="false">
                                                <li class="parsley-required text-end">{{ $message }}</li>
                                            </ul>
                                        
                                            </div>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-12 mb-2">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <p class="text-black" style="text-align: left;">
                                                            {!! $apart->terms_and_conditions !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 mb-4">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-warning btn-cal"><i
                                            class="fas fa-calculator"></i>
                                        {{ __('app.btn_cal') }}</button>
                                        <button type="submit" class="btn btn-primary btn-save-and-create"><i
                                                class="fas fa-save"></i>
                                            {{ __('app.btn_save_and_create') }}</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
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
