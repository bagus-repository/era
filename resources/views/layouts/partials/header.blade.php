<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        {{-- <img class="navbar-brand-full" src="{{ asset('img/logo.png') }}" width="89" height="25" alt="CoreUI Logo">
        <img class="navbar-brand-minimized" src="{{ asset('img/brand/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo"> --}}
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" role="button" aria-haspopup="true" aria-expanded="false">
            {{ auth()->user()->name }} <img class="img-avatar" src="{{ asset('img/avatars/7.jpg') }}" alt="{{ auth()->user()->name }}">
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
                <strong>{{ auth()->user()->name }}</strong>
            </div>
            <a class="dropdown-item" href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit()">
                <i class="fa fa-lock"></i> Logout
            </a>
            <form action="{{ route('auth.do_logout') }}" method="POST" id="logoutForm">
                @csrf
            </form>
        </div>
        </li>
    </ul>
</header>