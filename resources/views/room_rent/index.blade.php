@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="az-content-label mg-b-5">{{ __('app.label_table') }}{{ __('app.label_room_rent') }}</div>
                            <p class="mg-b-20">{{ __('app.label_table_room_info') }}</p>
                        </div>
                        <div class="col-sm-6 float-right">
                            <a href="{{ url('room-rent/create') }}"​ class="btn btn-az-secondary">{{ __('app.btn_new') }}</a>
                        </div>
                    </div>

                    <table id="example2" class="table dataTable dtr-inline" aria-describedby="example2_info"
                        style="min-width: -webkit-fill-available !important;">
                        <thead>
                            <tr>
                                <th class="wd-20p sorting" style="width: 30px;">{{ __('app.label_no') }}</th>
                                <th class="wd-20p sorting">{{ __('app.menu_room') }}</th>
                                <th class="wd-20p sorting">{{ __('app.label_price') }}</th>
                                <th class="wd-25p sorting">{{ __('app.label_customer_name') }}</th>
                                <th class="wd-20p sorting">{{ __('app.label_phone') }}</th>
                                <th class="wd-15p">{{ __('app.label_telegram')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roomRents as $key => $item)
                                <tr>
                                    <td tabindex="0" class="dtr-control">{{ ++$key }}</td>
                                    <td>{{ $item->room->name }}</td>
                                    <td>{{ $item->room->price }}</td>
                                    <td>{{ $item->customer_name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        <span class=" badge {{ $item->telegram_id != "" ? 'badge-inverse-success' : 'badge-inverse-danger' }}"><i class="fas {{ $item->telegram_id != "" ? "fa-check-circle":"fa-ban" }}"></i> {{ $item->telegram_id != "" ? __('app.btn_connected') :__('app.btn_disconnect') }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-icon-list">
                                            <a href="{{ url('room-rent/'.$item->room_rent_id.'/edit') }}" class="btn btn-indigo btn-icon me-2"><i
                                                    class="typcn typcn-edit"></i></a>
                                            <form method="POST" action="{{ route('room-rent.destroy', $item->room_rent_id) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-icon"><i
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
