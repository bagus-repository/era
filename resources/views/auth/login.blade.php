@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        {{-- <div class="text-right"><img src="{{ asset('img/simpati-logo.png') }}" alt="" height="75px"></div> --}}
                        <h1>Login</h1>
                        <p class="text-muted">Login ke akun anda</p>
                        <form class="spinner-form" action="{{ route('auth.do_login') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-envelope"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="text" placeholder="Email" name="email" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="icon-lock"></i>
                                    </span>
                                </div>
                                <input class="form-control" type="password" placeholder="Password" name="password"
                                    minlength="6" required>
                                <div class="input-group-append" onclick="toggle_password_name(this, 'password')">
                                    <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" name="remember_me" type="checkbox" value="1"
                                    id="chkRememberMe">
                                <label class="form-check-label" for="chkRememberMe">
                                    Remember me
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <button class="btn btn-primary px-4" type="submit">Login</button>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <a href="{{ route('auth.register_form') }}" class=""> Belum punya akun ?
                                            Daftar disini.</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    @include('control.password_visible')
    @include('control.form_submit')
@endsection
@endsection
