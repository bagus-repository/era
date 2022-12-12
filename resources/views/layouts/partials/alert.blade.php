@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
            <b>{!! $error !!}</b><br>
        @endforeach
    </div>
@elseif (session()->has('error'))
    <div class="alert alert-danger" role="alert">
        <b>{!! session()->get('error') !!}</b>
    </div>
@elseif (session()->has('success'))
    <div class="alert alert-success" role="alert">
        <b>{!! session()->get('success') !!}</b>
    </div>
@endif