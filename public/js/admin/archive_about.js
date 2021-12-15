$('textarea#short_text').ready(function() {
    setEditor(document.getElementById('short_text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$('textarea#full_text').ready(function() {
    setEditor(document.getElementById('full_text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function() {
    $(document).on('submit', 'form#update_archive', function(e) {
        e.preventDefault();
        updateArchive($(this));
    });

    $('body').on('change', '#update_archive input[type=file]', function (e) {
        e.preventDefault();
        $(this).siblings('.btn').find('span').text(this.files[0].name);
    });

    $('body').on('click', '.delete-event', function (e) {
        e.preventDefault();
        confirmModal();
        confirmationConfirmModal = function() {
            deleteArchive();
        };
    });
});

function deleteArchive() {
    request({
        url: document.location.pathname+'/delete',
        method: 'post',
        data: {},
        success: function(data) {
            if(data.url !== undefined)
                document.location.href = data.url
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

function updateArchive(form) {
    var inputWithError = undefined;
    form.find('input,select,textarea').each(function () {
        if ($(this).hasClass('required')) {
            if ((($(this).is('select') || $(this).is('input[type=number]')) && $(this).val() == 0) || $(this).val() == '') {
                inputWithError = $(this);
                return false;
            }
        }
    });
    if (typeof inputWithError === 'object')
        return inputError(inputWithError);

    var formData = new FormData(form.get(0));
    var buttonText = form.find('.programs-btn').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/update',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.programs-btn').text('Ждите...');
            form.find('.programs-btn').attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    if(data.message !== undefined)
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
            form.find('.programs-btn').text(buttonText);
            form.find('.programs-btn').removeAttr('disabled');
        }
    });
}