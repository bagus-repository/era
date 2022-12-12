@extends('layouts.app')

@push('csses')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endpush

@section('content')
<div class="animated fadeIn">
    <h3 class="mb-2">Quiz</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('quizzes.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Quiz</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="users-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pengguna</th>
                                    <th>Tanggal Quiz</th>
                                    <th>Durasi</th>
                                    <th>Mulai</th>
                                    <th>Akhir</th>
                                    <th>Total Score</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizes as $quiz)
                                <tr>
                                    <td>{{ $quiz->id }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $quiz->user) }}">{{ $quiz->user->name }}</a>
                                    </td>
                                    <td>{{ $quiz->batch_date }}</td>
                                    <td>{{ $quiz->duration }}</td>
                                    <td>{{ $quiz->start_time }}</td>
                                    <td>{{ $quiz->end_time }}</td>
                                    <td>
                                        {{ $quiz->total_score }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-primary btn-sm dropdown-toggle" href="javascript:void(0)" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Pilih Opsi
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="{{ route('quizzes.view_questions', $quiz) }}">Lihat Soal</a>
                                                <a class="dropdown-item" href="{{ route('quizzes.edit', $quiz) }}">Edit</a>
                                                <form action="{{ route('quizzes.destroy', $quiz) }}" method="post" id="delete-{{ $quiz->id }}" onsubmit="return confirm('Anda yakin ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item" data-btn="NC">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endpush

@section('script')
    <script>
        $(document).ready(function(){
            $('#users-table').DataTable();
        });
    </script>
@endsection