@extends('layouts.app')

@section('content')
<div class="animated fadeIn">
    <a href="{{ route('quizzes.index') }}" class="btn btn-primary btn-xs"><i class="fa fa-chevron-left"></i> Kembali ke list</a>
    <h3 class="mb-2">Buat Quiz</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <span class="required-label">*</span> wajib
                    </div>
                    <form class="spinner-form" action="{{ route('quizzes.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Pengguna Quiz <span class="required-label">*</span></label>
                            @include('control.select', [
                                'name' => 'user_id',
                                'arr_list' => $users,
                                'class' => 'form-control selectpicker',
                                'optVal' => 'id',
                                'optDesc' => ['id', 'name'],
                                'required' => 1,
                            ])
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Quiz <span class="required-label">*</span></label>
                            <input type="text" class="form-control datepicker" name="batch_date" required>
                        </div>
                        <div class="form-group">
                            <label for="">Durasi <span class="required-label">*</span></label>
                            <input type="number" class="form-control" name="duration" required>
                            <small class="form-text text-muted mb-3">Dalam menit</small>
                        </div>
                        <div class="form-group">
                            <label for="">Subject <span class="required-label">*</span></label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi <span class="required-label">*</span></label>
                            <textarea name="desc" class="form-control html-editor" rows="3"></textarea>
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
    @include('control.date_picker')
    @include('control.text_editor')
@endsection
@endsection
