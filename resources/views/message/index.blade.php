@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="az-content-label mg-b-5">{{ __('app.label_message_table') }}</div>
                            <p class="mg-b-20">{{ __('app.label_table_room_info') }}</p>
                        </div>
                        <div class="col-sm-6 float-right">
                            <a href="{{ url('message/create') }}"​ class="btn btn-az-secondary">{{ __('app.btn_new') }}</a>
                        </div>
                    </div>

                    <table id="example2" class="table dataTable table-responsive no-footer dtr-inline" cellspacing="0" style="min-width: -webkit-fill-available !important;">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="sorting">{{ __('app.label_no') }}</th>
                                <th class="sorting">{{ __('app.menu_room') }}</th>
                                <th class="sorting">{{ __('app.label_write_message') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $key => $item)
                            <tr>
                                <td class="dtr-control">
                                    <input type="checkbox" class="form-check form-check-input-custom form-check-input" name="select_room_id[]" value="{{ $item->id }}">
                                </td>
                                <td>{{ ++$key }}</td>
                                <td>
                                    @foreach (json_decode($item->room_rent_id) as $room_id)
                                    <label class="badge badge-primary h3">{{ $item->displayRoom($room_id) }}</label>
                                    @endforeach
                                </td>
                                <td>{{ $item->message }}</td>
                                <td>
                                    <div class="btn-icon-list">
                                        <a href="{{ url('message/'.$item->id.'/edit') }}" class="btn btn-indigo btn-icon me-2"  data-toggle="tooltip-primary" data-placement="top" title="{{ __('app.btn_edit')}}" data-bs-original-title="{{ __('app.btn_edit')}}"><i class="typcn typcn-edit"></i></a>
                                        <a href="{{ url('send-message/'.$item->id) }}" class="btn btn-primary btn-icon me-2" data-toggle="tooltip-primary" data-placement="top" title="{{ __('app.btn_send')}}" data-bs-original-title="{{ __('app.btn_send')}}"><i class="typcn typcn-location-arrow-outline"></i></a>
                                        <form method="POST" action="{{ route('message.destroy', $item->id) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-icon" data-toggle="tooltip-primary" data-placement="top" title="{{ __('app.btn_delete')}}" data-bs-original-title="{{ __('app.btn_delete')}}"><i
                                                class="typcn typcn-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
