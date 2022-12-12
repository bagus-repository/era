<script>
    $('form.spinner-form').on('submit', function(event){
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
    $('form.confirm-form').find('button[type=submit]').on('click', function(e){
            e.preventDefault();
            var form = $(this).parents('form');
            var confirmTitle = $(this).data('confirm-title');
            var confirmText = $(this).data('confirm-text');
            var confirmBtnOk = $(this).data('confirm-btn-ok');
            var confirmBtnCancel = $(this).data('confirm-btn-cancel');

            Swal.fire({
                title: confirmTitle ?? 'Konfirmasi',
                text: confirmText ?? "apakah anda yakin ?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmBtnOk ?? 'OK',
                cancelButtonText: confirmBtnCancel ?? 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
        });
    $('form.ajax-form').on('submit', function(e){
        var form = $(this);
        e.preventDefault();

        var btnSubmit = form.find('button[type=submit]');
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function(){
                btnSubmit.attr('disabled', true);
            },
            success: function(resp){
                if (resp.status == 1) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Sukses',
                        html: resp.msg,
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            if (resp.redirect) {
                                if (resp.redirect == 'refresh') {
                                    location.reload();
                                }else{
                                    location.assign(resp.redirect);
                                }
                            }
                        }
                    });
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Gagal',
                        html: resp.msg,
                    });
                }
            },
            error: function(error){
                console.log(error);
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    html: 'Silahkan coba lagi <br> ' + error.statusText
                });
            },
            complete: function(){
                btnSubmit.attr('disabled', false);
            }
        });
    });
</script>