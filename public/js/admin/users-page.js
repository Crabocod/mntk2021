$(document).ready(function (){
    showUsers();

    $('.excel-form').on('submit', function (e){
        e.preventDefault();
        var formData = new FormData($(this).get(0));
        let btn = $(this).find('.excel');
        var buttonText = btn.text();

        $.ajax({
            type: 'post',
            url: document.location.pathname + '/add-from-excel',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (jqXHR, textStatus) {
                btn.attr('disabled', 'disabled');
            },
            statusCode: {
                200: function (data) {
                    if (data.status === 'ok') {
                        successModal(data.message);
                        showUsers();
                    } else if (data.status === 'error') {
                        errorModal(data.message);
                    }
                },
                403: function () {
                    alert("Доступ запрещен! Пожалуйста, обновите страницу.")
                }
            },
            complete: function (jqXHR, textStatus) {
                btn.removeAttr('disabled');
            }
        });
    });

    $('#excel-file').on('change', function (){
        $('.excel-form').submit();
    });

    $('.excel').on('click', function (e){
        e.preventDefault();
        $('#excel-file').click();
    });

    $('.send-all').on('click', function (e){
        e.preventDefault();

        confirmModal();
        confirmationConfirmModal = function () {
            request({
                url: document.location.pathname + '/send-all-mail',
                method: 'post',
                success: function (data) {
                    successModal(data.message);
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });

    $(document).on('click', '.js-mail', function (e){
        e.preventDefault();
        mailUser($(this).attr('data-id'));
    });

    $(document).on('click', '.js-delete', function (e){
       e.preventDefault();

       deleteUser($(this).attr('data-id'));
    });

    $(document).on('submit', '.add-user', function (e){
        e.preventDefault();
        addUser($(this));
    });
});

function mailUser(id){
    var data = {
        'id': id
    }

    request({
        url: document.location.pathname + '/send-mail',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
    });
}

function deleteUser(id){
    var data = {
        'id': id
    }

    confirmModal();
    confirmationConfirmModal = function () {
        request({
            url: document.location.pathname + '/delete',
            method: 'post',
            data: data,
            success: function (data) {
                showUsers();
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    }
}

function addUser(form){
    if (form.find('input[name=full_name]').val() == '')
        return inputError(form.find('input[name=full_name]'));
    if (form.find('input[name=section_id]').val() == '')
        return inputError(form.find('input[name=section_id]'));
    if (form.find('input[name=email]').val() == '')
        return inputError(form.find('input[name=email]'));
    if (form.find('input[name=og_title]').val() == '')
        return inputError(form.find('input[name=og_title]'));
    if (form.find('input[name=phone]').val() == '')
        return inputError(form.find('input[name=phone]'));

    let btn = form.find('button[type=submit]');

    request({
        url: document.location.pathname + '/add',
        method: 'post',
        data: form.serializeArray(),
        success: function (data) {
            showUsers();
            successModal(data.message);
            form.find('input[name=full_name]').val('');
            form.find('input[name=phone]').val('');
            form.find('input[name=section_id]').val('');
            form.find('input[name=email]').val('');
            form.find('input[name=og_title]').val('');
        },
        error: function (data) {
            errorModal(data.message);
        },
        btn: btn
    });
}

function showUsers(){
    request({
        url: document.location.pathname + '/show-users',
        method: 'post',
        success: function (data) {
            $('.border-table .user-rows').remove();
            $('.add-user').before(data.html);
            MaskedPhone();
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}