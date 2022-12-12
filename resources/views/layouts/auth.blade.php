<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.15
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Bagus Budi Setyawan">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    @stack('csses')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  </head>
  <body class="app flex-row align-items-center">
    <div class="container">
        @yield('content')
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/app.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
    @include('control.sweetalert')
    @include('layouts.partials.alert2')
    @yield('script')
  </body>
</html>
