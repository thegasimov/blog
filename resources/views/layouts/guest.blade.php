<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Modern, flexible and responsive Bootstrap 5 admin &amp; dashboard template">
    <meta name="author" content="Bootlab">

    <title>{{ config('app.name') }}</title>

    <link href="{{ asset('assets/css/modern.css') }}" rel="stylesheet">

    <style>
        body {
            opacity: 0;
        }
    </style>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
</head>
<body class="theme-blue">
@include('sweetalert::alert')
<div class="splash active">
    <div class="splash-icon"></div>
</div>

<main class="main h-100 w-100">
    <div class="container h-100">
        @yield('content')
    </div>
</main>


<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('js')
</body>
</html>
