@extends('layouts.master')
@section('css')
    <style>
        input, select {
            color: #000 !important;
        }
    </style>
@endsection
@section('content')
    <div class="row row-sm mb-5 mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="d-flex flex-row justify-content-between">
                                <div class="pd-1">
                                </div>
                                <div class="pd-1">
                                    <button type="button" class="btn btn-default" id="progressReport">
                                        <img src="{{ asset('assets/img/loading.gif') }}" width="20px" alt="" srcset=""></i>
                                        {{ __('app.label_progress') }}</button>
                                    <button type="button" class="btn btn-az-secondary" data-id="{{ $invoice->id }}"
                                        id="saveReport"><i class="typcn typcn-camera-outline text-white"></i>
                                        {{ __('app.label_screenshot') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row screenshot mb-4">
                        <div class="col-sm-12">
                            <form action="#" method="post">
                                <div class="m-5">
                                    <div class="row mt-3 mb-4">
                                        <div class="col-sm-6 mb-4">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <h3>{{ __('app.invoice') }}</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 mb-4 text-end">
                                            <div class="input-group text-black" style="justify-content: end;">
                                                {{ __('app.label_day') }}<input type="text"
                                                    class="form-control-custom label_date" name="day"
                                                    value="{{ now()->format('d') }}">
                                                {{ __('app.label_month') }}<input type="text"
                                                    class="form-control-custom label_date" name="month"
                                                    value="{{ now()->format('m') == 12 ? 1 : now()->format('m') + 1 }}">
                                                {{ __('app.label_year') }}<input type="text"
                                                    class="form-control-custom label_date" name="year"
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
                                                <select class="select-control-custom room" name="room">
                                                    @foreach ($rooms as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-price="{{ $item->price }}"
                                                            class="select-control-custom-option" {{ $invoice->room_rent_id == $item->id ? 'selected' : '' }}>
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
                                                <input type="text" class="form-control-custom price text-end"
                                                    name="room_cost" placeholder="0" value="{{ $invoice->room_cost }}">
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
                                                <input type="text" class="form-control-custom text-end"
                                                    name="electric_cost" placeholder="0" value="{{ $invoice->electric_cost }}">
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
                                                <input type="text" class="form-control-custom" name="new_number"
                                                    placeholder="0" value="{{$invoice->water_new_number}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-3 mb-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend old_number" style="width: 82px">
                                                    <div class="input-group-text">
                                                        {{ __('app.label_old_number') }}
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control-custom" name="old_number"
                                                    placeholder="0" value="{{$invoice->water_old_number}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-4 mb-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control-custom water_cost text-end"
                                                    name="water_cost" placeholder="0" value="{{$invoice->water_cost}}">
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
                                                <input type="text" class="form-control-custom text-end"
                                                    name="trash_cost" placeholder="0" value="{{ $apart->trash_cost }}">
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
                                                <input type="text" class="form-control-custom text-end"
                                                    name="sub_total_amount" placeholder="0" value="{{ $invoice->sub_total_amount }}">
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
                                                <input type="text" class="form-control-custom text-end"
                                                    name="total_amount" placeholder="0" value="{{ $invoice->total_amount }}">
                                            </div>
                                        </div>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('assets/js/html2canvas.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#progressReport').hide()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var element = $('.page-screenshot');

            var id = window.location.pathname.split('/');
            $('#saveReport').on('click', function() {
                $('#progressReport').show();
                $('#saveReport').hide();
                html2canvas(document.querySelector(".screenshot")).then(canvas => {
                    var imgData = canvas.toDataURL("image/png");
                    $.ajax({
                        method: 'post',
                        url: '/invoice-base64-to-image',
                        data: {
                            id: id[3],
                            base64data: imgData
                        }
                    }).done(function(msg) {
                        window.location.replace('/invoice');
                        console.log(msg);
                    });
                });
            });
        });
    </script>
@endsection
