$('textarea#text').ready(function() {
    setEditor(document.getElementById('text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function () {
    showQuestions();

    $(document).on('click', '.delete-question', function (e) {
        e.preventDefault();
        let _this = $(this);
        confirmModal();
        confirmationConfirmModal = function () {
            deleteQuestion(_this.attr('data-id'));
        }
    });

    $('.add-question').on('submit', function (e) {
        e.preventDefault();
        
        addQuestion($(this));
    });

    $(document).on('click', '.save-question', function (e) {
        e.preventDefault();
        addQuestion($(this).closest('form'));
    });

    $(document).on('click', '.js-delete-img', function () {
        $(this).closest('.row-form_item').find('label').html('Прикрепить изображение');
        $(this).closest('.row-form_item').find('input[name=delete-img]').val(1);
        $(this).remove();
    });

    $(document).on('click', '.js-delete-audio', function () {
        $(this).closest('.row-form_item').find('label').html('Прикрепить аудио');
        $(this).closest('.row-form_item').find('input[name=delete-audio]').val(1);
        $(this).remove();
    });

    $(document).on('click', '.js-delete-file', function () {
        $(this).closest('.row-form_item').find('label').html('Прикрепить файлы');
        $(this).closest('.row-form_item').find('input[name=delete-file]').val(1);
        $(this).remove();
    });

    $('.text-save').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        request({
            url: document.location.pathname + '/save-text',
            method: 'post',
            data: form.serializeArray(),
            success: function (data) {
                successModal(data.message);
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    });
});

function deleteQuestion(id) {
    var data = {
        'id': id
    }
    console.log(id);
    request({
        url: document.location.pathname + '/delete-question',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
            showQuestions();
        },
        error: function (data) {
            errorModal(data.message);
        },
    });
}

function addQuestion(form) {
    if (form.find('textarea[name=text]').val() == '')
        return inputError(form.find('textarea[name=text]'));
    if (form.find('textarea[name=title]').val() == '')
        return inputError(form.find('textarea[name=title]'));
    if (form.find('input[name=number]').val() == '')
        return inputError(form.find('input[name=number]'));

    var formData = new FormData(form.get(0));
    let btn = form.find('.chrono-add');
    var buttonText = btn.text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-question',
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
                    showQuestions();
                    successModal(data.message);
                    form.find('textarea[name=text]').val('');
                    form.find('textarea[name=title]').val('');
                    form.find('input[name=number]').val('');
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

function showQuestions() {
    request({
        url: document.location.pathname + '/show-questions',
        method: 'post',
        success: function (data) {
            $('.question_rows').remove();
            $('.add-question').before(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        },
    });
}