$(document).ready(function(){
    $('.jq-add input').keypress(function(e){
        var code = e.keyCode || e.which;

        if( code === 13 ) {
            e.preventDefault();
            $( ".ajax-add" ).click();
        }
    });

    $('body').on('keypress', '.jq-save input', function(e){
        var code = e.keyCode || e.which;
        if( code === 13 ) {
            e.preventDefault();
            $(this).closest('.body-grid').find( ".ajax-update" ).click();
        }
    });

});

$(document).ready(function(){
    $(document).on('click', '.ajax-update', function (e) {
        e.preventDefault();
        var btn = $(this);

        if($(this).closest('.body-grid').find('.ajax-name input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-name input'));
        if($(this).closest('.body-grid').find('.ajax-surname input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-surname input'));
        if($(this).closest('.body-grid').find('.ajax-email input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-email input'));

        var data = {};
        data['id'] = $(this).closest('.btns-control').find('.user_id')[0].value;
        data['name'] = $(this).closest('.body-grid').find('.ajax-name input')[0].value;
        data['surname'] = $(this).closest('.body-grid').find('.ajax-surname input')[0].value;
        data['email'] = $(this).closest('.body-grid').find('.ajax-email input')[0].value;
        if ($(this).closest('.body-grid').find('.ajax-og input')[0].value != '') {
            data['og_title'] = $(this).closest('.body-grid').find('.ajax-og input')[0].value;
        }


        request({
            url: document.location.pathname+'/update',
            method: 'post',
            data: data,
            success: function (data) {
                successModal(data.message);
            },
            error: function (data) {
                errorModal(data.message);
            },
            button: btn
        });
    });

    $(document).on('click', '.ajax-delete', function (e) {
        e.preventDefault();
        confirmModal();
        var data = {};
        data['id'] = $(this).closest('.btns-control').find('.user_id')[0].value;
        var el = $(this).closest('.body-grid');
        confirmationConfirmModal = function (){
            request({
                url: document.location.pathname+'/delete',
                method: 'post',
                data: data,
                success: function (data) {
                    el.remove();
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });

    $(document).on('click', '.send-pass:not(.hover)', function (e) {
        e.preventDefault();
        var data = {};
        data['id'] = $(this).closest('.btns-control').find('.user_id')[0].value;
        var el = $(this);
        request({
            url: document.location.pathname+'/send-pass',
            method: 'post',
            data: data,
            success: function (data) {
                successModal(data.message);
                el.addClass('hover');
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    });

    $(document).on('click', '.send-pass.hover', function (e) {
        e.preventDefault();
        confirmModal('Хотите отправить пароль повторно?');
        var data = {};
        data['id'] = $(this).closest('.btns-control').find('.user_id')[0].value;
        var el = $(this);
        confirmationConfirmModal = function () {
            request({
                url: document.location.pathname + '/send-pass',
                method: 'post',
                data: data,
                success: function (data) {
                    successModal(data.message);
                    el.addClass('hover');
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });

    $(document).on('click', '.send-all-pass', function (e) {
        e.preventDefault();
        var el = $(this);
        request({
            url: document.location.pathname+'/send-all-pass',
            method: 'post',
            data: '',
            success: function (data) {
                successModal(data.message);
                $('.send-pass').addClass('hover');
            },
            error: function (data) {
                errorModal(data.message);
            },
            button: el
        });
    });

    $(document).on('click', '.ajax-add', function (e) {
        e.preventDefault();
        var btn = $(this);
        if($(this).closest('.body-grid').find('.ajax-name input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-name input'));
        if($(this).closest('.body-grid').find('.ajax-surname input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-surname input'));
        if($(this).closest('.body-grid').find('.ajax-email input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-email input'));

        var data = {};
        data['name'] = $(this).closest('.body-grid').find('.ajax-name input')[0].value;
        data['surname'] = $(this).closest('.body-grid').find('.ajax-surname input')[0].value;
        data['email'] = $(this).closest('.body-grid').find('.ajax-email input')[0].value;
        if ($(this).closest('.body-grid').find('.ajax-og input')[0].value != '') {
            data['og_title'] = $(this).closest('.body-grid').find('.ajax-og input')[0].value;
        }

        request({
            url: document.location.pathname+'/update',
            method: 'post',
            data: data,
            success: function (data) {
                $('.ajax-add').closest('.body-grid').find('.ajax-name input')[0].value = '';
                $('.ajax-add').closest('.body-grid').find('.ajax-surname input')[0].value = '';
                $('.ajax-add').closest('.body-grid').find('.ajax-email input')[0].value = '';
                $('.ajax-add').closest('.body-grid').find('.ajax-og input')[0].value = '';

                $(".jq-add").before(data.html);
            },
            error: function (data) {
                errorModal(data.message);
            },
            button: btn
        });
    });

    $('body').on('change', 'input[name=import-exl]', function (e) {
        if($(this).val() == '')
            return false;
        var form = $(this).closest('form');
        var formData = new FormData(form.get(0));
        var buttonText = form.find('.import-exl').text();

        $.ajax({
            type: 'post',
            url: document.location.pathname + '/add-from-excel',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (jqXHR, textStatus) {
                form.find('.import-exl').text('Ждите...');
                form.find('.import-exl').attr('disabled', 'disabled');
            },
            statusCode: {
                200: function (data) {
                    if (data.status === 'ok') {
                        successModal(data.message);
                        $(".jq-add").before(data.html);
                        form.find('input[type=file]').val('');
                    } else if (data.status === 'error') {
                        errorModal(data.message);
                    }
                },
                403: function () {
                    alert("Доступ запрещен! Пожалуйста, обновите страницу.")
                }
            },
            complete: function (jqXHR, textStatus) {
                form.find('.import-exl').text(buttonText);
                form.find('.import-exl').removeAttr('disabled');
            }
        });
    });
});