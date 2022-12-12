@extends('layouts.app')

@section('content')
<style>
    .answer-box{
        border: 1px #444343 solid;
        padding: 0.25rem;
        border-radius: 0.4rem;
        cursor: pointer;
    }
</style>
<div class="animated fadeIn">
    <h3 class="mb-2">Quiz Progress</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="{{ route('quizzes.summary', $quiz) }}" id="go_summary">
                        
                    </form>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <h4>{{ $quiz->subject }}</h4>
                            <h6><span id="fromCounter">{{ $from }}</span> dari <span id="toCounter">{{ $to }}</span> soal</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4><strong>Sisa Waktu : <span id="time">Loading...</span> menit</strong></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Jawab Pertanyaan Berikut ini (soal yang telah dijawab tidak akan muncul lagi) :</h5>
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                            <input type="hidden" name="current_qid" value="{{ $question->id }}">
                            <div id="Question" class="mb-4" style="border: 2px #0056b3 solid;padding: 0.5rem;border-radius: 0.5rem;">
                                {!! $question->question !!}
                            </div>
                            <div id="Answers">
                                @foreach ($question->answers as $item)
                                    <div class="answer-box mb-1" onclick="selectValue('{{ $item->id }}', this)">
                                        <input id="answer-{{ $item->id }}" type="radio" name="answer" value="{{ $item->id }}" required>
                                        {!! $item->answer !!}
                                    </div>
                                @endforeach
                            </div>
                            <button class="btn btn-success btn-md mt-4" type="button" onclick="submitAnswer(this)"> Submit Jawaban</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        function selectValue(id, el) {
            $('#answer-'+id).attr('checked', true);
            $('.answer-box').css('border-color', '#444343');
            $('.answer-box').css('border-width', '1px');
            $(el).css('border-color', '#28a745');
            $(el).css('border-width', '2px');
        }
        var time = {{ $quiz->remaining_time }};
        setInterval(function() {
            var seconds = time % 60;
            var minutes = (time - seconds) / 60;
            if (seconds.toString().length == 1) {
                seconds = "0" + seconds;
            }
            if (minutes.toString().length == 1) {
                minutes = "0" + minutes;
            }
            if (time <= 0) {
                document.getElementById("go_summary").submit();
            }else {
                document.getElementById("time").innerHTML = minutes + ":" + seconds;
                time--;
            }
        }, 1000);
        var counter = {{ $from }};
        function submitAnswer(el) {
            var btnSubmit = $(el);
            var current_qid = $('input[name=current_qid]');
            var answer_id = $('input[name=answer]:checked');
            var quiz_id = $('input[name=quiz_id]').val();

            if (answer_id.val() == '' || answer_id.val() === undefined) {
                Toast.fire({
                    icon: 'warning',
                    html: 'Mohon pilih salah satu jawaban'
                });
                return;
            }

            $.ajax({
                url: '{{ route('quizzes.do_ajax') }}',
                type: 'post',
                data: {
                    question_id: current_qid.val(),
                    answer_id: answer_id.val(),
                    quiz_id: quiz_id,
                },
                beforeSend: function(){
                    btnSubmit.attr('disabled', true);
                },
                success: function(resp){
                    if (resp.Status == false) {
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Error',
                            html: resp.Message,
                            showConfirmButton: true,
                            allowOutsideClick: false
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                if (resp.Payload.redirect == true) {
                                    location.assign(resp.Payload.redirect_url);
                                }
                            }
                        });
                    }else{
                        if (resp.Payload == null) {
                            document.getElementById("go_summary").submit();
                        }else{
                            $('#Answers').html('');
                            $('#fromCounter').text(++counter);
                            current_qid.val(resp.Payload.question_id);
                            resp.Payload.question.answers.forEach(el => {
                                $('#Answers').append('<div class="answer-box mb-1" onclick="selectValue(\''+el.id+'\', this)"><input id="answer-'+el.id+'" type="radio" name="answer" value="'+el.id+'" required>&nbsp;' + el.answer + '</div>');
                            });
                        }
                    }
                    btnSubmit.attr('disabled', false);
                },
                error: function(error){
                    btnSubmit.attr('disabled', false);
                    console.log(error);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Error',
                        html: 'Silahkan coba lagi <br> ' + error.statusText
                    });
                },
                complete: function(){
                    btnSubmit.attr('disabled', false);
                }
            });
        }
    </script>
@endsection