@php
    if (!isset($responsive)) {
        $responsive = 'false';
    }
@endphp
@php
    if (!isset($order)) {
        $order = '[[0, "asc"]]';
    }
@endphp
@php
    if(!isset($ordering)) {
        $ordering = 'true';
    }
@endphp
@php
    if(!isset($searching)) {
        $searching = 'true';
    }
@endphp
@php
    if(!isset($paging)) {
        $paging = 'true';
    }
@endphp
@php
    if(!isset($pageLength)) {
        $pageLength = 25;
    }
@endphp

@push('csses')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        var includedDT = $('.datatables').DataTable({
            paging: {{ $paging }},
            responsive: {{ $responsive }},
            order: {!! $order !!},
            ordering: {{ $ordering }},
            searching: {{ $searching }},
            columnDefs: [
               { targets: 'no-sort', orderable: false }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            pageLength: {{ $pageLength }},
        });
    </script>
@endpush

