@extends('layouts.app')

@section('content')
<div class="animated fadeIn">
    <a href="{{ route('questions.index') }}" class="btn btn-primary btn-xs"><i class="fa fa-chevron-left"></i> Kembali ke list</a>
    <h3 class="mb-2">Impor Pertanyaan</h3>
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <a href="{{ asset('template/template_question.xlsx') }}" class="btn btn-success btn-sm">Download Template</a>
                    <div class="text-right">
                        <span class="required-label">*</span> wajib
                    </div>
                    <form class="spinner-form" action="{{ route('questions.import') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Unggah File <span class="required-label">*</span></label>
                            <input type="file" name="file" class="form-control" accept="xlsx" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success btn-md" type="submit"><i class="fa fa-save"></i> Impor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    @include('control.form_submit')
@endsection
@endsection
