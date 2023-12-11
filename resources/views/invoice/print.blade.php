<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Room Rent System v2">
    <meta name="author" content="Karona Srun">
    <title>{{ Auth::User()->apartment->name ?? 'Azia' }}</title>
    <link href="{{ asset('assets/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/azia.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        .card {
            border: 1px solid transparent !important;
        }
    </style>
</head>

<body load="print" class="az-body">
    <div class="container-fluid">
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div>
                                    <div class="screenshot m-5">
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
                                                        value="{{ now()->format('m') }}">
                                                    {{ __('app.label_year') }}<input type="text"
                                                        class="form-control-custom label_date" name="year"
                                                        value="{{ now()->format('Y') }}">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.js') }}"></script>
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/azia.js') }}"></script>
    <script type="text/javascript">
        window.print();
        window.onafterprint = back;

        function back() {
            window.history.back();
        }
    </script>
</body>

</html>
