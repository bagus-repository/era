@extends('layouts.app')

@section('content')
<div class="animated fadeIn">
    <h3 class="mb-2">Summary Quiz</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h2>Test <b>{{ $quiz->subject }}</b> anda sudah selesai</h2>
                    <h4>Skor yang anda dapatkan</h4>
                    <span style="font-size: 4rem">{{ $quiz->total_score }}</span>
                    <br><br><br>
                    @if ($quiz->end_time == null)
                        <form action="{{ route('quizzes.finish', $quiz) }}" method="post">
                            @csrf
                            <button class="btn btn-success btn-md" type="submit"><i class="fa-solid fa-check-circle"></i> Selesaikan kuis</button>
                        </form>
                    @else
                        <a href="{{ route('home.index') }}" class="btn btn-primary btn-md">Kembali ke dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection