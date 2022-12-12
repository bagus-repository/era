@extends('layouts.app')

@push('csses')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endpush

@section('content')
<div class="animated fadeIn">
    <h3 class="mb-2">Pertanyaan</h3>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('questions.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pertanyaan</a>
                    <a href="{{ route('questions.import') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-import"></i> Impor Pertanyaan</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable" id="users-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Jumlah Jawaban</th>
                                    <th>Jawaban</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ question_truncate($item->question) }}</td>
                                    <td>{{ $item->answers->count() }}</td>
                                    <td>
                                        @if ($item->correct_answer)
                                            {{ $item->correct_answer->answer }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="btn btn-primary btn-sm dropdown-toggle" href="javascript:void(0)" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Pilih Opsi
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="{{ route('questions.edit', $item) }}">Edit</a>
                                                <form action="{{ route('questions.destroy', $item) }}" method="post" id="delete-{{ $item->id }}" onsubmit="return confirm('Anda yakin ?')">
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