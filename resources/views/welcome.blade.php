<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Room Rent System v2">
    <meta name="author" content="Karona Srun">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('assets/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    
    <link href="{{ asset('assets/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/azia.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

</head>

<body>

    <div class="az-header">
        <div class="container">
            <div class="az-header-left">
                <a href="{{ url('/') }}" class="az-logo"><span></span> AZia</a>
                <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
            </div>
            @guest
                <div class="az-header-right">
                    <a href="{{ url('/login') }}" class="btn btn-primary">{{ __('app.label_continue') }}</a>
                </div>
            @else
                <div class="az-header-right">
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">{{ __('app.menu_dashboard') }}</a>
                </div>
            @endguest
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
                </div>

                <div class="az-dashboard-nav">
                </div>

                <div class="row row-sm mg-b-20 mg-lg-b-0">
                    <div class="col-lg-12 col-xl-12 mg-t-20 mg-lg-t-0">
                        <div class="card card-table-one">
                            <h4 class="card-title h4">{{ __('app.menu_user') }}</h4>
                            <p class="az-content-text mg-b-20"></p>
                            <div class="mb-5">
                                <table id="example2" class=" dataTable table-responsive dtr-inline" aria-describedby="example2_info"
                                style="min-width: -webkit-fill-available !important;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('app.label_user_name') }}</th>
                                            <th>{{ __('app.label_email') }}</th>
                                            <th>{{ __('app.label_user_apart') }}</th>
                                            <th>{{ __('app.label_user_is_active') }}</th>
                                            <th>{{ __('app.label_user_last_login') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $key => $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('assets' . $item->image) }}"
                                                        class=" img-xs img-circle me-2">
                                                    {{ $item->name }}
                                                </td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->apartment->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->is_active == 0 ? 'badge-danger' : 'badge-success' }}">{{ $item->is_active ? __('app.label_user_active') : __('app.label_user_inactive') }}</span>
                                                </td>
                                                <td>
                                                    {{ $item->last_login == '' ? '' : KhmerDateTime\KhmerDateTime::parse($item->last_login)->format('LLLT') }}
                                                </td>
                                                <td>
                                                    <div class="btn-icon-list">
                                                        <a href="{{ url('/login-only-password',$item->id) }}"
                                                            class="btn btn-icon btn-az-primary"><i
                                                                class="fas fa-sign-in-alt text-white"
                                                                style="font-size: 20px;"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->
                        </div><!-- card -->
                    </div><!-- col-lg -->

                </div><!-- row -->
            </div><!-- az-content-body -->
        </div>
    </div>

    <div class="az-footer ht-40">
        <div class="container ht-100p pd-t-0-f">
            <span class="text-muted text-center">Copyright ©{{ now()->format('Y') }} {{ config('app.name') }}
                (Cambodia). All rights reserved.</span>
        </div>
    </div>


    <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/azia.js') }}"></script>
    <script src="{{ asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script>
      $(function() {
          $(".alert").delay(5000).slideUp(300);

          $('#example2').DataTable({
              "responsive": true,
              "paging": false,
              "lengthChange": true,
              "searching": false,
              "ordering": true,
              "info": false,
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
        });
    </script>
</body>

</html>
