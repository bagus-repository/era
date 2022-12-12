@extends('layouts.auth')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>Forgot Password</h1>
                <p class="text-muted">Reset your password</p>
                @include('layouts.partials.alert')
                <form action="{{ route('forgot.submit') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input class="form-control" type="email" placeholder="Email" name="email" required>
                    </div>
                    <button class="btn btn-block btn-success" type="submit"><i class="fa fa-airplane"></i> Send reset password</button>
                    <a class="btn btn-link pull-right" href="{{ route('login') }}">Login</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
