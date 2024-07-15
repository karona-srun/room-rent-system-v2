@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="az-content-label mg-b-5">{{ __('app.label_user_list') }}</div>
                            <p class="mg-b-20">{{ __('app.label_table_room_info') }}</p>
                        </div>
                        <div class="col-sm-6 float-right">
                            <a href="{{ url('user/create') }}"​ class="btn btn-az-secondary">{{ __('app.btn_new') }}</a>
                        </div>
                    </div>

                    <table id="example2" class="table dataTable table-responsive dtr-inline" aria-describedby="example2_info"
                        style="min-width: -webkit-fill-available !important;">
                        <thead>
                            <tr>
                                <th class="wd-20p sorting" style="width: 30px;"></th>
                                <th>{{ __('app.label_user_image') }}</th>
                                <th>{{ __('app.label_user_name') }}</th>
                                <th>{{ __('app.label_email') }}</th>
                                <th class="wd-20p sorting">{{ __('app.label_user_apart') }}</th>
                                <th>{{ __('app.label_user_is_active') }}</th>
                                <th>{{ __('app.label_user_last_login') }}</th>
                                <th>{{ __('app.label_created_at') }}</th>
                                <th class="wd-15p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $item)
                                <tr>
                                    <td tabindex="0" class="dtr-control">{{ ++$key }}</td>
                                    <td><img src="{{ asset('assets' . $item->image) }}" class=" img-xs img-circle"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @foreach ($item->apartments as $apart)
                                        <span class="badge badge-primary">{{ $apart->name }}</span>
                                        @endforeach
                                    </td>
                                    <td><span
                                            class="badge {{ $item->is_active == 0 ? 'badge-danger' : 'badge-success' }}">{{ $item->is_active ? __('app.label_user_active') : __('app.label_user_inactive') }}</span>
                                    </td>
                                    <td>{{ $item->last_login == '' ? '' : KhmerDateTime\KhmerDateTime::parse($item->last_login)->format('LLLT') }}
                                    </td>
                                    <td>{{ KhmerDateTime\KhmerDateTime::parse($item->created_at)->format('LLLT') }}</td>
                                    <td>
                                        <div class="btn-icon-list">
                                            <a href="{{ url('user/status/' . $item->id ) }}"
                                                class="btn btn-icon me-2 {{ $item->is_active == 1 ? 'btn-success': 'btn-danger'}}"><i class="typcn {{ $item->is_active == 1 ? 'typcn-input-checked-outline' : 'typcn-cancel-outline'}} text-white"></i></a>
                                            <a href="{{ url('user/change-password/' . $item->id) }}"
                                                class="btn btn-indigo btn-icon me-2"><i class="typcn typcn-key-outline"></i></a>
                                            <a href="{{ url('user/' . $item->id . '/edit') }}"
                                                class="btn btn-indigo btn-icon me-2"><i class="typcn typcn-edit"></i></a>
                                            <a href="{{ url('/user/destroy/' . $item->id) }}"
                                                class="btn btn-danger btn-icon me-2"><i class="typcn typcn-trash"></i></a>
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
