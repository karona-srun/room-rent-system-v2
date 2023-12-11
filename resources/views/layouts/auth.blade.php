
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        </div><!-- az-header-right -->
      </div><!-- container -->
    </div><!-- az-header -->

    <div class="az-content az-content-dashboard">
      <div class="container">
        <div class="az-content-body">
          <div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title">{{ __('app.label_hi')}} {{__('app.label_welcome')}}</h2>
              <p class="az-dashboard-text">{{__('app.label_your_dashboard')}}</p>
            </div>
            
          </div>
          <div class="az-dashboard-nav"> 
          </div>
          <div class="row row-sm mg-b-20 mg-lg-b-0">
            @yield('content')
          </div>
        </div>
      </div>
    </div>

    <div class="az-footer ht-40">
      <div class="container ht-100p pd-t-0-f">
        <span class="text-muted text-center">Copyright ©{{now()->format('Y')}} {{ config('app.name') }} (Cambodia). All rights reserved.</span>
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
