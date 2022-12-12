@extends('layouts.app')

@section('content')
<div class="animated fadeIn mt-3">
    <h3>Dashboard</h3>
    @if ($quizzes || count($quizzes) > 0)
        <div class="alert alert-info">
            Hari ini ada jadwal quiz, silahkan untuk mengerjakan quiz dibawah ini.
        </div>
        <div class="row">
            @foreach ($quizzes as $quiz)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-left">
                                <h4>{{ $quiz->subject }}</h4>
                            </div>
                            <div class="text-right">
                                @if ($quiz->start_time == null && $quiz->end_time == null)
                                    <form class="confirm-form" action="{{ route('quizzes.do', $quiz) }}" method="get">
                                        <button type="submit" class="btn btn-success btn-sm" data-confirm-title="Mulai Kuis ?" data-confirm-text="Waktu akan dihitung ketika anda klik mulai" data-confirm-btn-ok="Ya, mulai" data-confirm-btn-cancel="Nanti">Mulai</button>
                                    </form>
                                @elseif ($quiz->start_time != null && $quiz->end_time == null && $quiz->remaining_time != null)
                                    <form action="{{ route('quizzes.do', $quiz) }}" method="get">
                                        <button type="submit" class="btn btn-primary btn-sm">Lanjutkan</button>
                                    </form>
                                @else
                                    <form action="{{ route('quizzes.summary', $quiz) }}" method="get">
                                        <button type="submit" class="btn btn-secondary btn-sm">Lihat Hasil</button>
                                    </form>
                                    <span class="badge badge-success">Kuis Selesai</span>
                                @endif
                            </div>
                            {!! $quiz->desc !!}
                            <br><br>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@section('script')
    @include('control.form_submit')
@endsection