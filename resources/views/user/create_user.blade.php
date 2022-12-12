@extends('layouts.app')

@section('content')
<div class="animated fadeIn">
    <a href="{{ route('users.index') }}" class="btn btn-primary btn-xs"><i class="fa fa-chevron-left"></i> Kembali ke list</a>
    <h3 class="mb-2">Buat Pengguna</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <span class="required-label">*</span> wajib
                    </div>
                    <form class="spinner-form" action="{{ route('users.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama <span class="required-label">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email <span class="required-label">*</span></label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password <span class="required-label">*</span></label>
                            <input type="password" class="form-control" name="password" minlength="6" required>
                            <small class="form-text text-muted mb-3">Password minimal 6 karakter</small>
                        </div>
                        <div class="form-group">
                            <label for="">Ulangi Password <span class="required-label">*</span></label>
                            <input type="password" class="form-control" name="repassword" minlength="6" required>
                        </div>
                        <div class="form-group">
                            <label for="">Role <span class="required-label">*</span></label>
                            @include('control.select', [
                                'name' => 'role',
                                'arr_list' => $roles,
                                'class' => 'form-control selectpicker',
                                'optVal' => 'value',
                                'optDesc' => 'desc',
                                'required' => 1,
                            ])
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-md" type="submit"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    @include('control.form_submit')
    @include('control.select_picker')
@endsection
@endsection
