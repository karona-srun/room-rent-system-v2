<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Room Rent System v2">
    <meta name="author" content="Karona Srun">
    <title>{{ Auth::User()->apartment->name ?? 'Azia' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="fluid-icon" href="{{ asset('assets/img/' . Auth::User()->apartment->logo) }}" title="Azia">
    <link rel="mask-icon" href="{{ asset('assets/img/' . Auth::User()->apartment->logo) }}" color="#000000">
    <link rel="alternate icon" class="js-site-favicon" type="image/png"
        href="{{ asset('assets/img/' . Auth::User()->apartment->logo) }}">
    <link rel="icon" class="js-site-favicon" type="image/svg+xml"
        href="{{ asset('assets/img/' . Auth::User()->apartment->logo) }}">

    <link href="{{ asset('assets/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">

    <link href="{{ asset('assets/lib/lightslider/css/lightslider.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/azia.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Siemreap" rel="stylesheet">
    @yield('css')
    <style>
        html body {
            font-family: 'Siemreap' !important;
        }
    </style>
</head>

<body class="az-body az-dashboard-eight">
    <div class="az-header az-header-primary">
        <div class="container">
            <div class="az-header-left">
                <a href="{{ url('/dashboard') }}" class="az-logo">{{ Auth::User()->apartment->name ?? 'Azia' }}</a>
                <a href="" id="azNavShow" class="az-header-menu-icon d-lg-none"><span></span></a>
            </div><!-- az-header-left -->
            <div class="az-header-center">
                {{-- <input type="search" class="form-control" placeholder="Search for anything...">
                <button class="btn"><i class="fas fa-search"></i></button> --}}
            </div><!-- az-header-center -->
            <div class="az-header-right">
                <div class="az-header-message">
                    <a href="#"><small id="date">ថ្ងៃពុធ 29 វិច្ឆិកា 2023</small> <small
                            id="time">1:35:24 ល្ងាច</small></a>
                </div><!-- az-header-message -->
                <div class="dropdown az-profile-menu">
                    <a href="" class="az-img-user"><img src="{{ asset('assets' . Auth::user()->image) }}"
                            alt=""></a>
                    <div class="dropdown-menu">
                        <div class="az-dropdown-header d-sm-none">
                            <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                        </div>
                        <div class="az-header-profile">
                            <div class="az-img-user">
                                <img src="{{ asset('assets' . Auth::user()->image) }}" alt="">
                            </div><!-- az-img-user -->
                            <h6>{{ Auth::User()->name }}</h6>
                            <span>Premium Member</span>
                        </div><!-- az-header-profile -->

                        <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i>
                            {{ __('app.label_profile') }}</a>
                        <a href="" class="dropdown-item"><i class="typcn typcn-edit"></i>
                            {{ __('app.label_edit_profile') }}</a>
                        <a href="" class="dropdown-item"><i class="typcn typcn-time"></i>
                            {{ __('app.label_activity') }}</a>
                        <a href="" class="dropdown-item"><i class="typcn typcn-cog-outline"></i>
                            {{ __('app.label_account_setting') }}</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="typcn typcn-power-outline"></i> {{ __('app.label_sign_out') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div><!-- dropdown-menu -->
                </div>
            </div><!-- az-header-right -->
        </div><!-- container -->
    </div>
    <div class="az-navbar az-navbar-two az-navbar-dashboard-eight">
        <div class="container">
            <div class="az-navbar-header">
                <a href="{{ url('/dashboard') }}" class="az-logo">azia</a>
            </div>
            <ul class="nav">
                <li class="nav-label">
                    <p style="font-size: 1rem; color: #000;">{{ __('app.menu') }}</p>
                </li>
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}" class="nav-link"><i class="typcn typcn-clipboard"></i>
                        {{ __('app.menu_dashboard') }}</a>
                </li><!-- nav-item -->
                <li class="nav-item {{ Request::is('room*') || Request::is('room-rent*') ? 'active' : '' }}">
                    <a href="#" class="nav-link with-sub"><i class="typcn typcn-folder"></i>
                        {{ __('app.menu_room_info') }}</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item {{ Request::is('room*') ? 'active' : '' }}"><a
                                href="{{ url('room') }}" class="nav-sub-link">
                                {{ __('app.menu_room') }}</a></li>
                        <li class="nav-sub-item {{ Request::is('room-rent*') ? 'active' : '' }}"><a
                                href="{{ url('room-rent') }}" class="nav-sub-link">
                                {{ __('app.menu_room_rent') }}</a></li>
                    </ul>
                </li><!-- nav-item -->
                <li class="nav-item {{ Request::is('message*') ? 'active' : '' }}">
                    <a href="{{ url('message') }}" class="nav-link"><i class="typcn typcn-message"></i>
                        {{ __('app.menu_send_message') }}</a>
                </li><!-- nav-item -->
                <li class="nav-item {{ Request::is('invoice*') ? 'active' : '' }}">
                    <a href="" class="nav-link with-sub"><i class="typcn typcn-book"></i>
                        {{ __('app.menu_invoice') }}</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ url('invoice') }}" class="nav-sub-link active">
                                {{ __('app.menu_invoice_list') }}</a></li>
                        <li class="nav-sub-item"><a href="elem-alerts.html" class="nav-sub-link">
                                {{ __('app.menu_search_invoice') }}</a></li>
                    </ul>
                </li><!-- nav-item -->
                <li class="nav-item">
                    <a href="#" class="nav-link with-sub"><i class="typcn typcn-edit"></i>​
                        {{ __('app.menu_setting') }}</a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item"><a href="{{ url('user') }}" class="nav-sub-link">
                                {{ __('app.menu_user') }}</a></li>
                        <li class="nav-sub-item"><a href="{{ url('apartment') }}" class="nav-sub-link">
                                {{ __('app.label_apartment_info') }}</a></li>
                    </ul>
                </li><!-- nav-item -->
            </ul><!-- nav -->
        </div>
    </div>



    <div class="az-content az-content-dashboard">
        <div class="container">
            <div class="az-content-body">
                <div class="az-dashboard-one-title">
                    <div>
                        <h2 class="az-dashboard-title">{{ __('app.label_hi') }} {{ __('app.label_welcome') }}</h2>
                        <p class="az-dashboard-text">{{ __('app.label_your_dashboard') }}</p>
                    </div>
                    <div class="az-content-header-right">
                        @yield('button-right')
                    </div>
                </div>
                @include('alert')
                @yield('content')
            </div>
        </div>
    </div>

    <div class="az-footer ht-40">
        <div class="container ht-100p pd-t-0-f">
            <span class="text-muted text-center">Copyright ©{{ now()->format('Y') }} {{ config('app.name') }}
                (Cambodia). All rights reserved.</span>
        </div><!-- container -->
    </div><!-- az-footer -->

    <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/lib/lightslider/js/lightslider.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.js') }}"></script>
    <script src="{{ asset('assets/lib/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/azia.js') }}"></script>
    <script src="{{ asset('assets/js/chart.chartjs.js') }}"></script>
    <script>
        $(function() {

            $('.checkAll').click(function() {
                if ($(this).prop('checked')) {
                    $('.checkOne').prop('checked', true);
                } else {
                    $('.checkOne').prop('checked', false);
                }
            });

            $(".alert").delay(5000).slideUp(300);

            $('[data-toggle="tooltip"]').tooltip();

            $('.btn-save-and-create').click(function(e) {
                $('.saveAndCreate').val('new');
            })

            // colored tooltip
            $('[data-toggle="tooltip-primary"]').tooltip({
                template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            });

            $('[data-toggle="tooltip-secondary"]').tooltip({
                template: '<div class="tooltip tooltip-secondary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            });

            $('#example1').DataTable({
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_ items/page',
                }
            });

            $('.select2').select2({});

            $('.select2-no-search').select2({
                minimumResultsForSearch: Infinity,
            });

            $(".select_Room").select2({
                templateResult: function(data, container) {
                    if (data.element) {
                        $(container).addClass($(data.element).attr("blue"));
                    }
                    return data.text;
                }
            });

            $('.room').change(function(event) {
                var option = $('option:selected', this).attr('data-price');
                console.log("You have Selected  :: " + $(this).val() + " option:selected attr :: " +
                    option);
                var subZero = parseFloat(option);
                $('.price').val(subZero);
            });

            function readURL(input, previewId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(previewId).attr('src', e.target.result);
                        $(previewId).hide();
                        $(previewId).fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(".imagePreviewFront").unbind("click").bind("click", function() {
                $(".imageUploadFront").click();
            });

            $(".imagePreviewBack").unbind("click").bind("click", function() {
                $(".imageUploadBack").click();
            });

            $(".imageUploadFront").change(function() {
                readURL(this, '.imagePreviewFront');
            });

            $(".imageUploadBack").change(function() {
                readURL(this, '.imagePreviewBack');
            });

            $('#example2').DataTable({
                "responsive": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "language": {
                    "sProcessing": "ដំណើរការ...",
                    "sLengthMenu": "បង្ហាញ _MENU_ ទិន្នន័យ",
                    "sZeroRecords": "មិនមានទិន្នន័យនៅក្នុងតារាងនេះទេ។",
                    "sEmptyTable": "មិនមានទិន្នន័យនៅក្នុងតារាងនេះទេ។",
                    "sInfo": "បង្ហាញ _START_ ទៅ _END_ នៃ _TOTAL_ ទិន្នន័យ",
                    "sInfoEmpty": "បង្ហាញកំណត់ត្រាពី 0 ដល់ 0 ក្នុងចំណោមកំណត់ត្រាសរុប 0",
                    "sInfoFiltered": "(ការត្រងចេញពីកំណត់ត្រាសរុប _MAX_)",
                    "sInfoPostFix": "",
                    "sSearch": "ស្វែងរកទិន្នន័យ: ",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "ដំណើរការ...",
                    "oPaginate": {
                        "sFirst": "ដំបូង",
                        "sLast": "ចុងក្រោយ",
                        "sNext": "បន្ត",
                        "sPrevious": "ថយក្រោយ"
                    },
                    "oAria": {
                        "sSortAscending": ": ធ្វើឱ្យសកម្មដើម្បីតម្រៀបជួរឈរតាមលំដាប់ឡើង",
                        "sSortDescending": ": ធ្វើឱ្យសកម្មដើម្បីតម្រៀបជួរឈរតាមលំដាប់ចុះ"
                    }
                },
            });

            // Select2
            $('.dataTables_length select').select2({
                minimumResultsForSearch: Infinity
            });


            // Calculator invoice
            $('.old_number, .new_number').keyup(function() {
                var cost = $('.water_cost').attr('data-value');
                var oldVal = $('.old_number').val();
                var newVal = $('.new_number').val();
                console.log(cost);
                var total = (newVal - oldVal) * cost;

                $('.water_cost').val(total);
            });

            $('.btn-cal').click(function() {
                var water_cost = $('.water_cost').val();
                var trash_cost = $('.trash_cost').val();
                var room_cost = $('.room_cost').val();
                var eletrotic_cost = $('.electric_cost').val();

                var total_amount = '$' + (parseFloat(room_cost)) +
                    ' + ' + (parseFloat(trash_cost) + parseFloat(water_cost) + parseFloat(eletrotic_cost)) +
                    '៛';

                var total_riel = (parseFloat(trash_cost) + parseFloat(water_cost) + parseFloat(
                    eletrotic_cost));

                var exchange_riel = $('.trash_cost').attr('data-exchange');
                console.log(exchange_riel)

                var sumtotal = parseFloat(total_riel) / parseFloat(exchange_riel);
                var total = '$' + (parseFloat(room_cost) + parseFloat(sumtotal)).toFixed(2);

                if (total_amount == '$NaN + NaN៛') {
                    $('.total_amount').val(0.00);
                    $('.sub_total_amount').val(0.00);
                } else {
                    $('.sub_total_amount').val(total_amount);
                    $('.total_amount').val(total);
                }
            })
        });

        function showTime() {

            var myDate = new Date();

            let daysList = [],
                monthsList = [];
            if (document.documentElement.lang.toLowerCase() === "km") {
                daysList = ['ថ្ងៃអាទិត្យ', 'ថ្ងៃច័ន្ទ', 'ថ្ងៃអង្គារ៍', 'ថ្ងៃពុធ', 'ថ្ងៃព្រហស្បត្តិ៍', 'ថ្ងៃសុក្រ',
                    'ថ្ងៃសៅរ៍'
                ];
                monthsList = ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា',
                    'វិច្ឆិកា', 'ធ្នូ'
                ];
            } else {
                daysList = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                monthsList = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Aug', 'Oct', 'Nov', 'Dec'];
            }
            let date = 'ទី' + myDate.getDate();
            let month = monthsList[myDate.getMonth()];
            let year = myDate.getFullYear();
            let day = daysList[myDate.getDay()];

            let today = `${day} ${date} ${month} ${year}`;

            let amOrPm;
            let twelveHours = function() {
                if (myDate.getHours() > 12) {
                    amOrPm = 'ល្ងាច';
                    let twentyFourHourTime = myDate.getHours();
                    let conversion = twentyFourHourTime - 12;
                    return `${conversion}`

                } else {
                    amOrPm = 'ព្រឹក';
                    return `${myDate.getHours()}`
                }
            };
            let hours = twelveHours();
            let minutes = myDate.getMinutes();
            let seconds = myDate.getSeconds();

            let currentTime = `${hours}:${minutes}:${seconds} ${amOrPm}`;
            document.getElementById('date').innerHTML = ' ' + today + ' ';
            document.getElementById('time').innerHTML = ' ' + currentTime;
        }
        setInterval(showTime, 1000);
    </script>
    @yield('js')
</body>

</html>
