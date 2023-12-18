@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="az-content-label mg-b-5">{{ __('app.label_message_table') }}</div>
                            <p>{{ __('app.label_table_room_info') }} <br><strong>{{__('app.label_noted')}}៖</strong><br> - {{__('app.label_message_info')}}</p>
                        </div>
                        <div class="col-sm-4 float-right">
                            <a href="{{ url('message/create') }}"​ class="btn btn-az-secondary">{{ __('app.btn_new') }}</a>
                        </div>
                    </div>
                    <form action="{{ url('/send-message-all') }}" method="post">
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
                                            class="form-check form-check-input-custom form-check-input checkAll"
                                            name="id">
                                    </th>
                                    <th class="sorting">{{ __('app.label_no') }}</th>
                                    <th class="sorting">{{ __('app.menu_room') }}</th>
                                    <th class="sorting">{{ __('app.label_write_message') }}</th>
                                    <th>{{ __('app.label_send_noted') }}</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($messages as $key => $item)
                                    <tr>
                                        <td class="dtr-control">
                                            <input type="checkbox"
                                                class="form-check form-check-input-custom form-check-input checkOne"
                                                name="select_room_id[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            @foreach (json_decode($item->room_rent_id) as $room_id)
                                                <label
                                                    class="badge badge-primary h3">{{ $item->displayRoom($room_id) }}</label>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->message }}</td>
                                        <td>
                                            <span class="badge badge-info mb-1"><i class=" typcn typcn-input-checked"></i> {{ $item->telegram_message == 'done' ? 'ផ្ញើរួច' : 'នៅទេ' }}</span>
                                            <br>
                                            <span class="badge badge-primary"><i class=" typcn typcn-time"></i> {{ $item->telegram_message_at == "" ? "" : KhmerDateTime\KhmerDateTime::parse($item->telegram_message_at)->format('LLLLT') }}</span>
                                        </td>
                                        </td>
                                        <td>
                                            <div class="btn-icon-list">
                                                <a href="{{ url('message/' . $item->id . '/edit') }}"
                                                    class="btn btn-indigo btn-icon me-2" data-toggle="tooltip-primary"
                                                    data-placement="top" title="{{ __('app.btn_edit') }}"
                                                    data-bs-original-title="{{ __('app.btn_edit') }}"><i
                                                        class="typcn typcn-edit"></i></a>
                                                <a href="{{ url('send-message/' . $item->id) }}"
                                                    class="btn btn-primary btn-icon me-2" data-toggle="tooltip-primary"
                                                    data-placement="top" title="{{ __('app.btn_send') }}"
                                                    data-bs-original-title="{{ __('app.btn_send') }}"><i
                                                        class="typcn typcn-location-arrow-outline"></i></a>
                                                <a href="{{ url('message/destroy', $item->id) }}"
                                                    class="btn btn-danger btn-icon" data-toggle="tooltip-primary"
                                                    data-placement="top" title="{{ __('app.btn_delete') }}"
                                                    data-bs-original-title="{{ __('app.btn_delete') }}"><i
                                                        class="typcn typcn-trash"></i></a>
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
