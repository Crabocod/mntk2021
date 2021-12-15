var fullTextEditor = null;
$('textarea#full_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('full_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
        getInstance: function(editor) {
            fullTextEditor = editor;
        }
    });
});

$(document).ready(function () {
    $('body').on('submit', 'form#archive', function (e) {
        e.preventDefault();
        save($(this).closest('form'));
    });

    $('body').on('click', 'form#archive .btn-cancel:not([disabled])', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteArchive(form);
        };
    });

    $('body').on('change', 'input[name=link]', function (e) {
        e.preventDefault();
        addFile($(this).closest('form'));
    });

    $('body').on('click', '.document .btn-cancel:not([disabled])', function (e) {
        e.preventDefault();
        var button = $(this);
        confirmModal();
        confirmationConfirmModal = function () {
            deleteFile(button);
        };
    });

    $('body').on('click', '#archive_feedbacks .row-item .btn-cancel:not([disabled])', function (e) {
        e.preventDefault();
        var button = $(this);
        confirmModal();
        confirmationConfirmModal = function () {
            deleteArchiveFeedback(button);
        };
    });
});

function save(form) {
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

    var data = form.serializeArray();

    request({
        url: document.location.pathname + '/save-archive',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-save')
    });
}

function deleteArchive(form) {
    var data = {
        'id': form.find('input[name=id]').val()
    }

    request({
        url: document.location.pathname + '/delete-archive',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
            closeSuccessModal = function () {
                document.location.href = data.url
            }
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-cancel')
    });
}

function addFile(form) {
    if (form.find('input[name=link]').val() == '')
        return false;

    var formData = new FormData(form.get(0));
    var buttonText = form.find('span').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/add-archive-file',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('span').text('Ждите...');
            form.find('input[name=link]').attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    form.closest('#add-file-row').before(data.html);
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            form.find('span').text(buttonText);
            form.find('input[name=link]').removeAttr('disabled');
        }
    });
}

function deleteFile(button) {
    var data = {
        'id': button.closest('[archive_file_id]').attr('archive_file_id')
    }

    request({
        url: document.location.pathname + '/delete-archive-file',
        method: 'post',
        data: data,
        success: function (data) {
            button.closest('[archive_file_id]').remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}

function deleteArchiveFeedback(button) {
    var data = {
        'id' : button.closest('[archive_feedback_id]').attr('archive_feedback_id')
    }

    request({
        url: document.location.pathname + '/delete-archive-feedback',
        method: 'post',
        data: data,
        success: function (data) {
            button.closest('[archive_feedback_id]').remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}