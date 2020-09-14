<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin | laravelBlog</title>

        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="">
        <meta property="og:site_name" content="">
        <meta property="og:description" content="">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset('public/admin/assets/media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('public/admin/assets/media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/admin/assets/media/favicons/apple-touch-icon-180x180.png') }}">
        <!-- END Icons -->

        <!-- Stylesheets -->

        @yield('css_before')

        <!-- Fonts and Codebase framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{ asset('public/admin/assets/css/codebase.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('public/admin/assets/css/custom.css') }}">

        @yield('css_after')
    </head>
    <body>
        <!-- Page Container -->
        @yield('content')
        <!-- END Page Container -->

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-terms" aria-hidden="true">
        </div>
        <!-- END Modal -->

        <script src="{{ asset('public/admin/assets/js/codebase.core.min.js') }}"></script>
        <script src="{{ asset('public/admin/assets/js/codebase.app.min.js') }}"></script>
        <script src="{{ asset('public/admin/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

        <!-- Page JS Plugins -->
        <script src="{{ asset('public/admin/assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

        <!-- Page JS Code -->
        <script src="{{ asset('public/admin/assets/js/custom.js') }}"></script>

        <script type="text/javascript">
            // Load notifications
            $(document).ready(function() {
                loadNotification();

                setInterval(function(){
                    loadNotification();
                }, 30000);
            });

            function loadNotification() {
                $.ajax({
                    url: '{{ url("/admin/notification") }}',
                    success: function(response) {
                        $('#notification').html(response);
                    }
                });
            }
        </script>

        @yield('js_after')
    </body>
</html>