$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.app-body form, .spinner-form').on('submit', function(event){
    var btnSubmits = $(this).find('button[type=submit]');
    if (btnSubmits.length > 0) {
        btnSubmits.each(function(){
            var btnSubmit = $(this);
            if (btnSubmit.attr('data-btn') != 'NC') {
                btnSubmit.attr('disabled', true);
                var btnText = btnSubmit.text();
                btnSubmit.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'+btnText);
            }
        });
    }
});

$('button.navbar-toggler.sidebar-toggler').on('click', function(e){
    e.preventDefault();
    if (Boolean(sessionStorage.getItem('sidebar-toggle-collapsed'))) {
        sessionStorage.setItem('sidebar-toggle-collapsed', '');
    } else {
        sessionStorage.setItem('sidebar-toggle-collapsed', '1');
    }
});

$('.input-counter').each(function(){
    var maxlength = $(this).attr("maxlength");
    var currentLength = $(this).val().length;
    if (maxlength) {
        $(this).after('<small class="text-muted text-counter d-flex justify-content-end">'+(maxlength-currentLength)+' karakter lagi<small>')
    }
});
$('.input-counter').on('input', function(){
    var maxlength = $(this).attr("maxlength");
    var currentLength = $(this).val().length;
    if (maxlength) {
        $(this).next().text((maxlength - currentLength)+' karakter lagi');
    }
});

function reInitInputCounter() {
    $('.input-counter').each(function(){
        var maxlength = $(this).attr("maxlength");
        var currentLength = $(this).val().length;
        if (maxlength) {
            $(this).next().html('');
            $(this).after('<small class="text-muted text-counter d-flex justify-content-end">'+(maxlength-currentLength)+' karakter lagi<small>');
        }
    });
    $('.input-counter').on('input', function(){
        var maxlength = $(this).attr("maxlength");
        var currentLength = $(this).val().length;
        if (maxlength) {
            $(this).next().text((maxlength - currentLength)+' karakter lagi');
        }
    });
}