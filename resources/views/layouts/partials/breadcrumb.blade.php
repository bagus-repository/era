@if (count($breadcrumbs))
<ol class="breadcrumb">
    <li class="breadcrumb-item">Home</li>
    @foreach ($breadcrumbs as $breadcrumb)
        @if ($loop->last)
        <li class="breadcrumb-item active">
            <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
        </li>
        @else
        <li class="breadcrumb-item">
            <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
        </li>
        @endif
    @endforeach
</ol>
@endif