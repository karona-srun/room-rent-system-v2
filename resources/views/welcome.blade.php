
<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE') }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Room Rent System v2">
    <meta name="author" content="Karona Srun">
    <title></title>
    <link href="{{ asset('assets/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
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
        <div class="az-header-right">
            <a href="{{ url('/login') }}" class="btn btn-primary">{{__('app.label_continue')}}</a>
        </div>
      </div>
    </div>

    <div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          <div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title">{{ __('app.label_hi')}} {{__('app.label_welcome')}}</h2>
              <p class="az-dashboard-text">{{__('app.label_your_dashboard')}}</p>
            </div>
            <div class="az-content-header-right">
              <div class="media">
                <div class="media-body">
                  <label>{{ __('app.label_start_date')}}</label>
                  <h6>Oct 10, 2018</h6>
                </div><!-- media-body -->
              </div><!-- media -->
              <div class="media">
                <div class="media-body">
                  <label>{{ __('app.label_end')}}</label>
                  <h6>Oct 23, 2018</h6>
                </div><!-- media-body -->
              </div>
            </div>
          </div><!-- az-dashboard-one-title -->

          <div class="az-dashboard-nav"> 
            {{-- <nav class="nav">
              <a class="nav-link active" data-toggle="tab" href="#">Overview</a>
              <a class="nav-link" data-toggle="tab" href="#">Audiences</a>
              <a class="nav-link" data-toggle="tab" href="#">Demographics</a>
              <a class="nav-link" data-toggle="tab" href="#">More</a>
            </nav> --}}

            {{-- <nav class="nav">
              <a class="nav-link" href="#"><i class="far fa-save"></i> Save Report</a>
              <a class="nav-link" href="#"><i class="far fa-file-pdf"></i> Export to PDF</a>
              <a class="nav-link" href="#"><i class="far fa-envelope"></i>Send to Email</a>
              <a class="nav-link" href="#"><i class="fas fa-ellipsis-h"></i></a>
            </nav> --}}
          </div>

          <div class="row row-sm mg-b-20 mg-lg-b-0">
            <div class="col-lg-12 col-xl-12 mg-t-20 mg-lg-t-0">
              <div class="card card-table-one">
                <h6 class="card-title">What pages do your users visit</h6>
                <p class="az-content-text mg-b-20">Part of this date range occurs before the new users metric had been calculated, so the old users metric is displayed.</p>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="wd-5p">&nbsp;</th>
                        <th class="wd-45p">Country</th>
                        <th>Entrances</th>
                        <th>Bounce Rate</th>
                        <th>Exits</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><i class="flag-icon flag-icon-us flag-icon-squared"></i></td>
                        <td><strong>United States</strong></td>
                        <td><strong>134</strong> (1.51%)</td>
                        <td>33.58%</td>
                        <td>15.47%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-gb flag-icon-squared"></i></td>
                        <td><strong>United Kingdom</strong></td>
                        <td><strong>290</strong> (3.30%)</td>
                        <td>9.22%</td>
                        <td>7.99%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-in flag-icon-squared"></i></td>
                        <td><strong>India</strong></td>
                        <td><strong>250</strong> (3.00%)</td>
                        <td>20.75%</td>
                        <td>2.40%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-ca flag-icon-squared"></i></td>
                        <td><strong>Canada</strong></td>
                        <td><strong>216</strong> (2.79%)</td>
                        <td>32.07%</td>
                        <td>15.09%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-fr flag-icon-squared"></i></td>
                        <td><strong>France</strong></td>
                        <td><strong>216</strong> (2.79%)</td>
                        <td>32.07%</td>
                        <td>15.09%</td>
                      </tr>
                      <tr>
                        <td><i class="flag-icon flag-icon-ph flag-icon-squared"></i></td>
                        <td><strong>Philippines</strong></td>
                        <td><strong>197</strong> (2.12%)</td>
                        <td>32.07%</td>
                        <td>15.09%</td>
                      </tr>
                    </tbody>
                  </table>
                </div><!-- table-responsive -->
              </div><!-- card -->
            </div><!-- col-lg -->

          </div><!-- row -->
        </div><!-- az-content-body -->
      </div>
    </div><!-- az-content -->

    <div class="az-footer ht-40">
      <div class="container ht-100p pd-t-0-f">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
      </div><!-- container -->
    </div><!-- az-footer -->


    <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/lib/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/peity/jquery.peity.min.js') }}"></script>

    <script src="{{ asset('assets/js/azia.js') }}"></script>
    <script src="{{ asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script>
      $(function(){

      });
    </script>
  </body>
</html>
