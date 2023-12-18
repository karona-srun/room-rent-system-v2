@extends('layouts.master')

@section('content')
    <div class="row mb-5 bg-white">
        <div class="col-sm-8 p-3">
            {{__('app.label_info_monthly')}}<hr>
            <div class="d-md-flex flex-row justify-content-center mt-3">
                <div class="d-flex" style="width: 100vh; height: 20%">
                    {!! $chartLine->render() !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="mb-3 mt-4">
                <div class="card-header">{{ __('app.menu_room_info') }}</div>
                <div class="card-body">
                    <div class="az-content-label mg-b-5">ក្រាបបង្ហាញបន្ទប់ និងបន្ទប់ជួល</div>

                    <div class="d-md-flex flex-row justify-content-center mt-3">
                        <div class="d-flex">
                            {!! $chartjs->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-sm-12 mb-3 bg-white p-4">
            <div class="row">
                <div class="card-header mb-3">{{ __('app.label_info_summary') }}</div>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('app.label_count_room') }}</div>
                        <div class="card-body">
                            <h3 class="text-start">{{$data['room']}}</h3>
                            <a href="{{url('/room')}}" class="btn btn-block btn-sm btn-outline-primary">{{__('app.label_info_detail')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('app.label_count_room') }}</div>
                        <div class="card-body">
                            <h3 class="text-start">{{$data['room_rent']}}</h3>
                            <a href="{{url('/room-rent')}}" class="btn btn-block btn-sm btn-outline-primary">{{__('app.label_info_detail')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mb-3">
                    <div class="card">
                        <div class="card-header">{{ __('app.label_count_user') }}</div>
                        <div class="card-body">
                            <h3 class="text-start">{{$data['user']}}</h3>
                            <a href="{{url('/user')}}" class="btn btn-block btn-sm btn-outline-primary">{{__('app.label_info_detail')}}</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-3 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-header">{{__('app.label_info_monthly'). __('app.label_income_as_riel') }}<span class="text-danger">[៛]</span></div>
                        <div class="card-body">
                            <h3 class="text-start">{{$data['total_riel']}}</h3>
                            <a href="{{url('/invoice')}}" class="btn btn-block btn-sm text-white btn-outline-primary">{{__('app.label_info_detail')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mb-3">
                    <div class="card  bg-success text-white">
                        <div class="card-header">{{__('app.label_info_monthly'). __('app.label_income_as_dollar')}}<span class="text-danger">[$]</span></div>
                        <div class="card-body">
                            <h3 class="text-start">{{$data['total_dollar']}}</h3>
                            <a href="{{url('/invoice')}}" class="btn btn-block text-white btn-sm btn-outline-primary">{{__('app.label_info_detail')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
