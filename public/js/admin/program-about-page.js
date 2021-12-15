$('textarea#text').ready(function() {
    setEditor(document.getElementById('text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function (){
    $('.js-delete').on('click', function (e){
        e.preventDefault();
        var data = {
            'id': $(this).closest('form').find('input[name=id]').val()
        }

        confirmModal();
        confirmationConfirmModal = function () {
            request({
                url: '/admin/programs/delete-program',
                method: 'post',
                data: data,
                success: function (data) {
                    location.href = '/admin/programs';
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });

    $('.add-program').on('submit', function (e){
        e.preventDefault();
        addProgram($(this));
    });
});

function addProgram(form){
    if (form.find('textarea[name=text]').val() == '')
        return ckeditorError(form.find('.ck-editor__editable'));
    if (form.find('input[name=title]').val() == '')
        return inputError(form.find('input[name=title]'));
    if (form.find('input[name=date]').val() == '')
        return inputError(form.find('input[name=date]'));

    var formData = new FormData(form.get(0));
    let btn = form.find('.btn-submit');
    var buttonText = btn.text();

    $.ajax({
        type: 'post',
        url: '/admin/programs/save-program',
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
                    successModal(data.message);
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