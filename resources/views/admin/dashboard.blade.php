@extends('admin.layouts.default')

@section('css_before')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin/assets/js/plugins/slick/slick-theme.css') }}">
@endsection

@section('content')
<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-fixed">
    <!-- Sidebar -->
    @include('admin.include.sidebar')
    <!-- END Sidebar -->

    <!-- Header -->
    @include('admin.include.header')
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="content">
            <div class="row invisible" data-toggle="appear">
                <div class="col-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="{{ url('/admin/category') }}">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="fa fa-th-list fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $category }}">0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Categories</div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="{{ url('/admin/blog') }}">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10 d-none d-sm-block">
                                <i class="fa fa-rss fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $blog }}">0</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Blog</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                @if(!empty($blog_views))
                <div class="col-xl-6">
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Blog Views</h3>
                        </div>
                        <div class="block-content block-content-full text-center">
                            <!-- Lines Chart Container -->
                            <canvas class="js-chartjs-lines"></canvas>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    @include('admin.include.footer')
    <!-- END Footer -->
</div>
@endsection

@section('js_after')
<script src="{{ asset('public/admin/assets/js/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('public/admin/assets/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>

@if(!empty($blog_views))
<script type="text/javascript">
    var chartjs  = jQuery('.js-chartjs-lines');

    var chart = new Chart(chartjs, { 
        type: 'line', 
        data: {
            labels: {!! json_encode($blog_views["days"]) !!},
            datasets: [
                {
                    label: 'Last {{ count($blog_views["days"]) }} Days',
                    fill: true,
                    backgroundColor: 'rgba(66,165,245,.25)',
                    borderColor: 'rgba(66,165,245,1)',
                    pointBackgroundColor: 'rgba(66,165,245,1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(66,165,245,1)',
                    data: {!! json_encode($blog_views["views"]) !!}
                }
            ]
        },
        options : {
             scales: {
                 yAxes: [{
                     ticks: {
                         beginAtZero: true,
                         userCallback: function(label, index, labels) {
                             // when the floored value is the same as the value we have a whole number
                             if (Math.floor(label) === label) {
                                 return label;
                             }

                         },
                     }
                 }],
             },
         }
    });
</script>
@endif
@endsection