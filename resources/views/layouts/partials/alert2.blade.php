@if ($errors->any())
    <div id="AlertError" style="display: none">
        @foreach ($errors->all() as $error)
            <b>{!! $error !!}</b><br>
        @endforeach
    </div>
    <script>
        Toast.fire({
            icon: 'error', 
            html: $('#AlertError').html(),
        });
    </script>
@elseif (session()->has('error'))
    <div id="AlertError" style="display: none">
        <b>{!! session()->get('error') !!}</b>
    </div>
    <script>
        Toast.fire({
            icon: 'error', 
            html: $('#AlertError').html(),
        });
    </script>
@elseif (session()->has('success'))
    <div id="AlertSuccess" style="display: none">
        <b>{!! session()->get('success') !!}</b>
    </div>
    <script>
        Toast.fire({
            icon: 'success', 
            html: $('#AlertSuccess').html(),
        });
    </script>
@elseif (session()->has('info'))
    <div id="AlertInfo" style="display: none">
        <b>{!! session()->get('info') !!}</b>
    </div>
    <script>
        Toast.fire({
            icon: 'info', 
            html: $('#AlertInfo').html(),
        });
    </script>
@endif