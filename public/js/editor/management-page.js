var textEditor = null;
var topTextEditor = null;
$('textarea#text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
        getInstance: function(editor) {
            textEditor = editor;
        }
    });
});
$('textarea#top_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('top_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
        getInstance: function(editor) {
            topTextEditor = editor;
        }
    });
});

$(document).ready(function () {
    $('body').on('submit', 'form#management', function (e) {
        e.preventDefault();
        save($(this).closest('form'));
    });

    $('body').on('click', '#feedbacks .row-item .btn-cancel:not([disabled])', function (e) {
        e.preventDefault();
        var button = $(this);
        confirmModal();
        confirmationConfirmModal = function () {
            deleteFeedback(button);
        };
    });

    $('body').on('click', 'form#management .file-delete', function (e) {
        e.preventDefault();
        $(this).siblings('label').find('span').text('Прикрепить...');
        $(this).siblings('input[name=file]').val('');
        $(this).siblings('input[name=deleted_file]').val(1);
        $(this).css('display', 'none');
    });

    $('body').on('change', '.inputfile', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
        $(this).closest('div').find('input[name=audio_change]').val(1);
        $(this).siblings('.radio-audio-delete').css('display', 'inline-block');
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

    var formData = new FormData(form.get(0));
    var buttonText = form.find('.btn-save').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.btn-save').text('Ждите...');
            form.find('.btn-save').attr('disabled', 'disabled');
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
            form.find('.btn-save').text(buttonText);
            form.find('.btn-save').removeAttr('disabled');
        }
    });
}

function deleteFeedback(button) {
    var data = {
        'id' : button.closest('[management_feedback_id]').attr('management_feedback_id')
    }

    request({
        url: document.location.pathname + '/delete-feedback',
        method: 'post',
        data: data,
        success: function (data) {
            button.closest('[management_feedback_id]').remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}