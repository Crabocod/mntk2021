$('textarea#text').ready(function() {
    setEditor(document.getElementById('text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function (){
    showPrograms();
    $('.add-program').on('submit', function (e){
        e.preventDefault();
        addProgram($(this));
    });

    $(document).on('change', '.custom-checkbox', function (){
        let data = {
            'id':$(this).attr('data-id')
        };

        request({
            url: document.location.pathname + '/public-programs',
            method: 'post',
            data: data,
            success: function (data) {
                successModal(data.message);
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    });

    $(document).on('click', '.row-form', function (e){
        if($(e.target).hasClass('custom-checkbox'))
            return;
        if($(e.target).hasClass('checkbox-js'))
            return;
        if($(e.target).hasClass('btn-cancel js-delete'))
            return;
        location.href = '/admin/programs/'+$(this).attr('data-id');
    });

    $(document).on('click', '.js-delete', function (e){
        e.preventDefault();
        var data = {
            'id': $(this).attr('data-id')
        }

        confirmModal();
        confirmationConfirmModal = function () {
            request({
                url: '/admin/programs/delete-program',
                method: 'post',
                data: data,
                success: function (data) {
                    showPrograms();
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });
});

function showPrograms() {
    request({
        url: document.location.pathname + '/show-programs',
        method: 'post',
        success: function (data) {
            $('.border-table .row-form').remove();
            $('.border-table').append(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        },
    });
}

function addProgram(form){
    if (form.find('input[name=img_link]').val() == '')
        return errorModal('Необходимо добавить обложку новости');
    if (form.find('input[name=date]').val() == '')
        return inputError(form.find('input[name=date]'));
    if (form.find('input[name=title]').val() == '')
        return inputError(form.find('input[name=title]'));
    if (form.find('textarea[name=text]').val() == '')
        return ckeditorError(form.find('.ck-editor__editable'));

    var formData = new FormData(form.get(0));
    let btn = form.find('.btn-submit');
    var buttonText = btn.text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-program',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            btn.text('Ждите...');
            btn.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    showPrograms();
                    successModal(data.message);
                    form.find('input[name=title]').val('');
                    form.find('textarea[name=text]').val('');
                    form.find('input[name=date]').val('');
                    form.find('input[name=img_link]').val('');
                    form.find('input[name=iframe]').val('');
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            btn.text(buttonText);
            btn.removeAttr('disabled');
        }
    });
}