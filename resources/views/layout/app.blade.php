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
    <link href="{{ asset('coreui/css/coreui.css') }}" rel="stylesheet">

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

<!-- Scripts -->
<script src="{{ asset('coreui/js/coreui.bundle.min.js') }}"></script>
</body>
</html>
