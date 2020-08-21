<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Logistics Service">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Logistics - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('coreui/css/coreui.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>

</head>
<body class="c-app">
@include('layout.sidebar')
<div class="c-wrapper c-fixed-components">
    @include('layout.header')
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                <div class="fade-in">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    @include('layout.footer')

</div>
<!-- Style -->
<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
<!-- Scripts -->
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/moment.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ asset('coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
@stack('scripts')
</body>
</html>
