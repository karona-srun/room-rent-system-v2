@extends('layouts.master')

@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="az-content-label mg-b-5">{{ __('app.label_apartment_info') }}</div>
                            <p class="mg-b-20">{{ __('app.label_table_room_info') }}</p>
                        </div>
                        <div class="col-sm-6 float-right">
                            <a href="{{ url('apartment/create') }}"​
                                class="btn btn-az-secondary">{{ __('app.label_create_apartment') }}</a>
                        </div>
                    </div>

                    <table id="example2" class="table dataTable table-responsive dtr-inline" aria-describedby="example2_info"
                        style="min-width: -webkit-fill-available !important;">
                        <thead>
                            <tr>
                                <th class="wd-20p sorting" style="width: 30px;"></th>
                                <th>{{ __('app.label_user_image') }}</th>
                                <th class="wd-20p sorting" tabindex="0" aria-controls="example2" rowspan="1"
                                    colspan="1">{{ __('app.label_apartment') }}</th>
                                <th class="wd-20p sorting">{{ __('app.label_exchange_riel') }} <span
                                        class="text-danger">[៛]</span></th>
                                <th class="wd-25p sorting">{{ __('app.label_water_cost') }} <span
                                        class="text-danger">[៛]</span></th>
                                <th class="wd-25p sorting">{{ __('app.trash_cost') }} <span class="text-danger">[៛]</span>
                                </th>
                                <th>{{ __('app.label_address') }}</th>
                                <th class="wd-15p"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartment as $key => $item)
                                <tr>
                                    <td tabindex="0" class="dtr-control">{{ ++$key }}</td>
                                    <td><img src="{{ asset('assets/img/' . $item->logo) }}" width="60px"
                                            class="img-circle"></td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->exchange_riel }}</td>
                                    <td>{{ $item->water_cost }}</td>
                                    <td>{{ $item->trash_cost }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>
                                        <div class="btn-icon-list">
                                            <a href="{{ url('apartment/' . $item->id . '/edit') }}"
                                                class="btn btn-indigo btn-icon me-2"><i class="typcn typcn-edit"></i></a>
                                            <form method="POST" action="{{ route('apartment.destroy', $item->id) }}">
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
