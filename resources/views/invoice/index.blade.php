@extends('layouts.master')
@section('css')

<!-- jQuery UI -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
@endsection
@section('content')
    <div class="row row-sm mg-b-20 mg-lg-b-0 mb-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bd bd-t-0">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="az-content-label mg-b-5">{{ __('app.label_room_list') }}</div>
                            <p class="mg-b-20">{{ __('app.label_table_room_info') }}<br><strong>{{__('app.label_noted')}}៖</strong><br> - {{__('app.label_message_info')}} <br> - {{__('app.label_invoice_info')}}</p>
                        </div>
                        <div class="col-sm-4 float-right">
                            <a href="{{ url('invoice/create') }}"​
                                class="btn btn-primary btn-with-icon btn-block">{{ __('app.btn_new') }}</a>
                        </div>
                    </div>
                    <form action="{{ url('invoice') }}" method="get">
                        <div class="row mb-3">
                            <div class="col-sm-3 mb-2">
                                <div class="form-group">
                                <label for="" class="mb-2">{{__('app.label_invoice_search')}}</label>
                                <input type="text" name="keyword" class="form-control" placeholder="ស្វែងរក..." value="{{ Request::get('keyword') }}">
                            </div>
                            </div>
                            <div class="col-sm-3 mb-2 form-group">
                                <label for="" class="mb-2">{{__('app.label_start_date')}}</label>
                                <input type="text" name="start_date" id="start_date" class="form-control start_date" placeholder="ជ្រើសរើស" value="{{  Request::get('start_date') != '' ? Request::get('start_date'): Carbon\Carbon::parse(date('Y-m').'-'.$apart->start_date )->format('Y-m-d') }}">
                            </div>
                            <div class="col-sm-3 mb-2">
                                <label for="" class="mb-2">{{__('app.label_end')}}</label>
                                <input type="text" name="end_date" id="end_date" class="form-control end_date" placeholder="ជ្រើសរើស" value="{{  Request::get('start_date') != '' ? Request::get('end_date'): Carbon\Carbon::parse(date('Y-m').'-'.$apart->end_date )->format('Y-m-d') }}">
                            </div>
                            <div class="col-sm-3 mb-2">
                                <button type="submit" class="btn btn-primary"  style="line-height: 20px; margin-top: 32px; height: 38px;"><i
                                        class=" typcn typcn-business-card"></i> {{ __('app.menu_search_invoice') }}</button>
                            </div>
                        </div>
                    </form>
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
                                        <input type="checkbox" class="form-check-input text-center checkAll" name="id">
                                    </th>
                                    <th>{{ __('app.label_no') }}</th>
                                    <th class="wd-10p">{{ __('app.menu_room') }}</th>
                                    <th>{{ __('app.label_invoice_date') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_created_at') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_total_amount') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_status_pay') }}</th>
                                    <th class="wd-20p sorting">{{ __('app.label_screenshot') }}</th>
                                    <th class="wd-20p">{{ __('app.label_send_noted') }}</th>
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
                                        <td>
                                            <span class="badge badge-dark mb-1">{{ $item->invoice_no }}</span>
                                            {{ KhmerDateTime\KhmerDateTime::parse($item->invoice_date)->format('LLL') }}
                                        </td>
                                        <td>{{ KhmerDateTime\KhmerDateTime::parse($item->created_at)->format('LLT') }}
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
                                            <span class="badge badge-info mb-1"><i class=" typcn typcn-input-checked"></i>
                                                {{ $item->telegram_message == 'done' ? 'ផ្ញើរួច' : 'នៅទេ' }}</span>
                                            <br>
                                            <span class="badge badge-primary"><i class=" typcn typcn-time"></i>
                                                {{ $item->telegram_message_at == '' ? '' : KhmerDateTime\KhmerDateTime::parse($item->telegram_message_at)->format('LLT') }}</span>
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
                                                <a href="{{ url('invoice/destroy', $item->id) }}"
                                                    class="btn btn-danger btn-icon"><i class="typcn typcn-trash"></i></a>
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
@section('js')

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function () {
    $.datepicker.regional['km'] = {
		closeText: 'ធ្វើ​រួច',
		prevText: 'មុន',
		nextText: 'បន្ទាប់',
		currentText: 'ថ្ងៃ​នេះ',
		monthNames: ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា',
		'កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'],
		monthNamesShort: ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា',
		'កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'],
		dayNames: ['អាទិត្យ', 'ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'],
		dayNamesShort: ['អាទិត្យ', 'ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'],
		dayNamesMin: ['អាទិត្យ', 'ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហ', 'សុក្រ', 'សៅរ៍'],
		weekHeader: 'សប្ដាហ៍',
		dateFormat: 'yy-mm-dd',
		firstDay: 2,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['km']);
    $('#start_date, #end_date').datepicker();
});
</script>
@endsection