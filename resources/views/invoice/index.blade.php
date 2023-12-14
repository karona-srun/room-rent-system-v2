@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0 mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="az-content-label mg-b-5">{{ __('app.label_room_list') }}</div>
                            <p class="mg-b-20">{{ __('app.label_table_room_info') }}</p>
                        </div>
                        <div class="col-sm-6 float-right">
                            <a href="{{ url('invoice/create') }}"​ class="btn btn-az-secondary">{{ __('app.btn_new') }}</a>
                        </div>
                    </div>
                    <form action="{{ url('invoice/send-all') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">{{ __('app.btn_send_all') }}</button>
                            </div>
                        </div>
                        <table id="example2" class="table dataTable table-responsive no-footer dtr-inline" cellspacing="0"
                            style="min-width: -webkit-fill-available !important;">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox"
                                            class="form-check-input text-center checkAll"
                                            name="id">
                                    </th>
                                    <th>{{ __('app.label_no') }}</th>
                                    <th class="wd-10p">{{ __('app.menu_room') }}</th>
                                    <th>{{ __('app.label_invoice_date') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_created_at') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_total_amount') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_status_pay') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_screenshot') }}</th>
                                    <th class="wd-20p">{{__('app.label_send_noted')}}</th>
                                    <th class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $key => $item)
                                    <tr>
                                        <td class="dtr-control">
                                            <input type="checkbox"
                                                class="form-check form-check-input-custom form-check-input checkOne"
                                                name="select_room_id[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item->room->name }}</td>
                                        <td>{{ KhmerDateTime\KhmerDateTime::parse($item->invoice_date)->format('LLL') }}
                                        </td>
                                        <td>{{ KhmerDateTime\KhmerDateTime::parse($item->created_at)->format('LLLT') }}
                                        </td>
                                        <td>{{ $item->sub_total_amount }} ឬ {{ $item->total_amount }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $item->is_paid == 0 ? 'badge-warning' : 'badge-success' }}">{{ $item->is_paid == 0 ? __('app.label_not_pay') : __('app.label_paid') }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $item->is_screenshot == 0 ? 'badge-warning' : 'badge-success' }}">{{ $item->is_screenshot == 0 ? __('app.label_not_yet') : __('app.label_done') }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-info mb-1"><i class=" typcn typcn-input-checked"></i> {{ $item->telegram_message == 'done' ? 'ផ្ញើរួច' : 'នៅទេ' }}</span>
                                            <br>
                                            <span class="badge badge-primary"><i class=" typcn typcn-time"></i> {{ $item->telegram_message_at == "" ? "" : KhmerDateTime\KhmerDateTime::parse($item->telegram_message_at)->format('LLLLT') }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-icon-list">
                                                <a href="{{ url('invoice/pay/' . $item->id) }}"
                                                    class="btn btn-success btn-icon me-2"><i
                                                        class=" typcn typcn-ticket text-white"></i></a>
                                                <a href="{{ url('invoice/send/' . $item->id) }}"
                                                    class="btn btn-success btn-icon me-2"><i
                                                        class="typcn typcn-location-arrow-outline text-white"></i></a>
                                                <a href="{{ url('invoice/screenshot/' . $item->id) }}"
                                                    class="btn btn-info btn-icon me-2"><i
                                                        class="typcn typcn-camera-outline text-white"></i></a>
                                                <a href="{{ url('invoice/print/' . $item->id) }}"
                                                    class="btn btn-info btn-icon me-2"><i
                                                        class="typcn typcn-printer text-white"></i></a>
                                                <a href="{{ url('invoice/' . $item->id . '/edit') }}"
                                                    class="btn btn-indigo btn-icon me-2"><i
                                                        class="typcn typcn-edit"></i></a>
                                                <a href="{{ url('invoice/destroy', $item->id) }}" class="btn btn-danger btn-icon"><i
                                                            class="typcn typcn-trash"></i></a>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
