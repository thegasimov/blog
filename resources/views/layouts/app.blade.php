<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Modern, flexible and responsive Bootstrap 5 admin &amp; dashboard template">
    <meta name="author" content="Bootlab">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('assets/css/modern.css') }}?ver={{ time() }}" rel="stylesheet">
    <style>
        body {
            opacity: 0;
        }
    </style>
    @stack('css')
    <script src="{{ asset('assets/js/settings.js') }}?ver={{ time() }}"></script>
</head>
<body>
@include('sweetalert::alert')
<div class="splash active">
    <div class="splash-icon"></div>
</div>
<div class="wrapper">
    @include('layouts.navigation')
    <div class="main">
        <nav class="navbar navbar-expand navbar-theme mt-5">
            <a class="sidebar-toggle d-flex me-2">
                <i class="hamburger align-self-center"></i>
            </a>
            @include('layouts.navbar')
        </nav>
        @yield('content')
    </div>
</div>


<script src="{{ asset('assets/js/app.js') }}?ver={{ time() }}"></script>
@stack('js')
</body>
</html>
