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
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <!-- Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="icon" type="image/ico" href="./img/favicon.ico" sizes="any" />
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/themes@5.0.15/default/default.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      const Toast = Swal.mixin({
          toast: true,
          position: 'top',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          iconColor: 'white',
          customClass: {
              popup: 'colored-toast'
          },
          onOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      });
  </script>
    @stack('csses')
    <style>
      
    </style>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed">
    <script>
      if (sessionStorage.getItem('sidebar-toggle-collapsed') === null) {
        sessionStorage.setItem('sidebar-toggle-collapsed', '1');
      }
      if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        var wrapper = document.getElementsByClassName('app')[0];
        wrapper.className += ' sidebar-lg-show';
      }
    </script>
    @include('layouts.partials.header')
    <div class="app-body">
      @include('layouts.partials.sidebar')
      <main class="main">
        <!-- Breadcrumb-->
        @yield('breadcrumb')
        <div class="container-fluid">
          <div class="pt-2">
            @yield('content')
          </div>
        </div>
      </main>
    </div>
    @include('layouts.partials.footer')
    @yield('modals')
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    @stack('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
    @include('layouts.partials.alert2')
    @yield('script')
    @yield('modals')
  </body>
</html>
