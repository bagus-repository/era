@extends('layouts.app')

@section('content')
<div class="animated fadeIn">
    <a href="{{ route('questions.index') }}" class="btn btn-primary btn-xs"><i class="fa fa-chevron-left"></i> Kembali ke list</a>
    <h3 class="mb-2">Ubah Pertanyaan</h3>
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <span class="required-label">*</span> wajib
                    </div>
                    <div id="AnswerClone" style="display: none">
                        <div class="row mb-2" id="Answer">
                            <div class="col-md-2">
                                <input type="radio" name="is_answer" id="is_answer" value="AnswerValue" required> Jawaban Benar
                            </div>
                            <div class="col-md-8">
                                <textarea id="AnswerEditor" name="answers[]" rows="3" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <form class="spinner-form" action="{{ route('questions.update', $question) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Pertanyaan <span class="required-label">*</span></label>
                            <textarea name="question" rows="3" class="form-control html-editor">{!! $question->question !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Skor <span class="required-label">*</span></label>
                            <input type="text" name="score" class="form-control" value="{{ $question->score }}" required>
                        </div>
                        <div class="form-group" id="WrapperAnswers">
                            <label for="">
                                Jawaban <span class="required-label">*</span>
                                <button type="button" class="btn btn-sm btn-primary" onclick="addAnswerArea()"><i class="fa-solid fa-plus"></i> Add Answer</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeAnswerArea()"><i class="fa-solid fa-minus"></i> Remove Answer</button>
                            </label>
                            @foreach ($question->answers as $item)
                                <div class="row mb-2" id="Answer{{ $loop->iteration }}">
                                    <div class="col-md-2">
                                        <input type="radio" name="is_answer" id="is_answer" value="1" {{ $item->is_answer == 1 ? 'checked':'' }} required> Jawaban Benar
                                    </div>
                                    <div class="col-md-8">
                                        <textarea id="AnswerEditor{{ $loop->iteration }}" name="answers[]" rows="3" class="form-control" required>{!! $item->answer !!}</textarea>
                                    </div>
                                </div>
                            @endforeach
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
    @include('control.text_editor')
    <script>
        var counter = {{ $question->answers->count() }};
        var maxCounter = 4;
        function addAnswerArea() {
            if (counter == maxCounter) {
                Toast.fire({
                    icon: 'warning',
                    html: 'Maksimal 4 jawaban',
                });
                return;
            }
            var answer = $('#AnswerClone').html();
            counter++;
            $('#WrapperAnswers').append(
                answer.replace('Answer', 'Answer' + counter)
                    .replace('AnswerEditor', 'AnswerEditor' + counter)
                    .replace('AnswerValue', counter)
                );
        }
        function removeAnswerArea() {
            if (counter == 1) {
                Toast.fire({
                    icon: 'warning',
                    html: 'Minimal 1 jawaban',
                });
                return;
            }
            $('#Answer' + counter).remove();
            counter--;
        }
    </script>
@endsection
@endsection
