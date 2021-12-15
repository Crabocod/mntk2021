$('textarea#og_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('og_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('form#save-og').submit(function (e) {
        e.preventDefault();
        saveOG($(this));
    });

    $('body').on('change', '#file-1', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
    });
});

function saveOG(form){
    var inputWithError = undefined;
    form.find('input,textarea').each(function () {
        if ($(this).hasClass('required')) {
            if ($(this).val() == '') {
                inputWithError = $(this);
                return false;
            }
        }
    });
    if (typeof inputWithError === 'object')
        return inputError(inputWithError);

    var formData = new FormData(form.get(0));
    var buttonText = form.find('.btn-save-green').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-og',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.btn-save-green').text('Ждите...');
            form.find('.btn-save-green').attr('disabled', 'disabled');
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
            form.find('.btn-save-green').text(buttonText);
            form.find('.btn-save-green').removeAttr('disabled');
        }
    });
}