@extends('layouts.auth')

@section('title', 'Register')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>Register</h1>
                <p class="text-muted">Buat akun anda</p>
                <form class="spinner-form" action="{{ route('auth.do_register') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-user"></i>
                            </span>
                        </div>
                        <input class="form-control" type="text" placeholder="Nama Lengkap" name="name" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input class="form-control" type="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input class="form-control" type="password" placeholder="Password" name="password" required minlength="6">
                        <div class="input-group-append" onclick="toggle_password_name(this, 'password')">
                            <span class="input-group-text"><i class="fa fa-eye"></i></span>
                        </div>
                    </div>
                    <small class="form-text text-muted mb-3">Password minimal 6 karakter</small>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input class="form-control" type="password" placeholder="Ulangi Password" name="repassword" required>
                        <div class="input-group-append" onclick="toggle_password_name(this, 'repassword')">
                            <span class="input-group-text"><i class="fa fa-eye"></i></span>
                        </div>
                    </div>
                    <button class="btn btn-block btn-success" type="submit">Buat Akun</button>
                    <a class="btn btn-link pull-right" href="{{ route('auth.login_form') }}">Sudah punya akun ? Login disini.</a>
                </form>
            </div>
        </div>
    </div>
</div>
@section('script')
    @include('control.password_visible')
    @include('control.form_submit')
@endsection

@endsection
