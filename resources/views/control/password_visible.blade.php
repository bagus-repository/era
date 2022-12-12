<script>
    function toggle_password(el) {
        var btn = $(el).find('span[class="input-group-text"]');
        var input = $('input[name=password]');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            btn.html('<i class="fa fa-eye-slash"></i>');
        }else{
            input.attr('type', 'password');
            btn.html('<i class="fa fa-eye"></i>');
        }
    }
    function toggle_password_name(el, name) {
        var btn = $(el).find('span[class="input-group-text"]');
        var input = $('input[name='+name+']');
        if (input.attr('type') == 'password') {
            input.attr('type', 'text');
            btn.html('<i class="fa fa-eye-slash"></i>');
        }else{
            input.attr('type', 'password');
            btn.html('<i class="fa fa-eye"></i>');
        }
    }
</script>