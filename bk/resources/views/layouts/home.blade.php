<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,600" rel="stylesheet" type="text/css"> -->

    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">

    <!-- Styles -->
    <style>
        body {
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
            background-color: #243949;
            color: #fff;
            /*background-image: url("http://v3pos.nextpage.info/public/img/home-bg1.jpg");*/
        }

        .navbar-default {
            border: none;
            padding: 10px 0px;
        }

        .navbar-static-top {
            margin-bottom: 19px;
        }

        .navbar-default .navbar-nav>li>a {
            color: #fff;
            font-weight: 600;
            font-size: 15px
        }

        .navbar-default .navbar-nav>li>a:hover {
            color: #ccc;
        }

        .navbar-default .navbar-brand {
            color: #ccc;
        }

        .title {
            font-size: 40px !important;
        }
    </style>
</head>

<body class="fixed">
    @include('layouts.partials.home_header')
    <div class="container">
        <div class="content home-content">
            @yield('content')
        </div>
    </div>
    @include('layouts.partials.javascripts')

    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
    @yield('javascript')
</body>

</html>