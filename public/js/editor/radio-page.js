var textEditor = null;
$('textarea#radio_main_schedule_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('radio_main_schedule_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
        getInstance: function(editor) {
            textEditor = editor;
        }
    });
});

$(document).ready(function () {
    $('body').on('change', '.row-image input', function (e) {
        e.preventDefault();
        readLocalImage(this, $(this).siblings('img.image'));
        $(this).siblings('img.image').css('display', 'inherit');
        $(this).siblings('span').css('display', 'none');
        $(this).parent().siblings('img.image__delete').css('display', 'inherit');
    });

    $('body').on('click', '.row-image .image__delete', function (e) {
        e.preventDefault();
        var elem = $(this).siblings('.thumbnail_div');
        elem.find('img.image').css('display', 'none');
        elem.find('span').css('display', 'inherit');
        elem.find('input[name=img]').val('');
        elem.find('input[name=deleted_img]').val(1);
        $(this).css('display', 'none');
    });

    $('body').on('click', '#add-row .btn-save:not([disabled])', function (e) {
        e.preventDefault();
        addLive($(this).closest('tr'));
    });

    $('body').on('click', '.update-row .btn-save:not([disabled])', function (e) {
        e.preventDefault();
        updateLive($(this).closest('tr'));
    });

    $('body').on('change', '.audio_file', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
        $(this).closest('div').find('input[name=audio_change]').val(1);
        $(this).siblings('.radio-audio-delete').css('display', 'inline-block');
    });

    $('body').on('click', 'form#save-radio .radio-audio-delete', function (e) {
        e.preventDefault();
        $(this).siblings('label').find('span').text('Прикрепить...');
        $(this).siblings('input[name=audio]').val('');
        $(this).siblings('input[name=deleted_audio]').val(1);
        $(this).css('display', 'none');
    });

    $('body').on('click', '#add-archive .btn-save', function (e) {
        e.preventDefault();
        addArchive($(this).closest('form'));
    });

    $('body').on('click', '#update-archive .btn-save', function (e) {
        e.preventDefault();
        updateArchive($(this).closest('form'));
    });

    $('body').on('click', '.btn-cancel-black:not([disabled])', function (e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteLive(tr);
        };
    });

    $('body').on('click', '#update-archive .btn-cancel', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteRadioArchive(form);
        };
    });

    $('form#save-radio').submit(function (e) {
        e.preventDefault();
        saveRadio($(this));
    });

    $('body').on('change', 'input[name=radio_main_schedule_img1]', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
        $(this).siblings('.delete-image-1').css('display', 'inline-block');
    });

    $('body').on('click', 'form#save-main-schedule .delete-image-1', function (e) {
        e.preventDefault();
        $(this).siblings('label').find('span').text('Прикрепить...');
        $(this).siblings('input[name=radio_main_schedule_img1]').val('');
        $(this).siblings('input[name=deleted_image_1]').val(1);
        $(this).css('display', 'none');
    });

    $('body').on('change', 'input[name=radio_main_schedule_img2]', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
        $(this).siblings('.delete-image-2').css('display', 'inline-block');
    });

    $('body').on('click', 'form#save-main-schedule .delete-image-2', function (e) {
        e.preventDefault();
        $(this).siblings('label').find('span').text('Прикрепить...');
        $(this).siblings('input[name=radio_main_schedule_img2]').val('');
        $(this).siblings('input[name=deleted_image_2]').val(1);
        $(this).css('display', 'none');
    });

    $('body').on('submit', 'form#save-main-schedule', function(e) {
        e.preventDefault();
        saveMainSchedule($(this));
    });
});

function saveRadio(form){
    var inputWithError = undefined;
    form.find('input').each(function () {
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
    var buttonText = form.find('.btn-submit').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-radio',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.btn-submit').text('Ждите...');
            form.find('.btn-submit').attr('disabled', 'disabled');
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
            form.find('.btn-submit').text(buttonText);
            form.find('.btn-submit').removeAttr('disabled');
        }
    });
}

function deleteRadioArchive(form) {
    var data = {'id' : form.find('input[name=id]').val()}

    request({
        url: document.location.pathname+'/delete-archive',
        method: 'post',
        data: data,
        success: function (data) {
            form.remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-cancel')
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
    var buttonText = form.find('.btn-save').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/update-archive',
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

function addArchive(form) {
    var inputWithError = undefined;
    form.find('input, textarea').each(function () {
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
        url: document.location.pathname + '/save-archive',
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
                    form.before(data.html);
                    form.find('input').val('');
                    form.find('textarea').val('');
                    form.find('label span').text('Прикрепить...');
                    form.find('.add-icon-row img').css('display', 'none');
                    form.find('.add-icon-row span').css('display', 'inherit');
                    litepickerRestart();
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

function updateLive(row) {
    if (row.find('input[name=title]').val() == '')
        return inputError(row.find('input[name=title]'));
    if (row.find('input[name=date]').val() == '')
        return inputError(row.find('input[name=date]'));
    if (row.find('input[name=date_from]').val() == '')
        return inputError(row.find('input[name=date_from]'));
    if (row.find('input[name=date_to]').val() == '')
        return inputError(row.find('input[name=date_to]'));
    if (row.find('input[name=speaker]').val() == '')
        return inputError(row.find('input[name=speaker]'));
    if (row.find('textarea[name=text]').val() == '')
        return inputError(row.find('textarea[name=text]'));

    var button = row.find('.btn-save');
    var buttonText = button.text();

    var formData = new FormData(row.find('form')[0]);
    formData.append('id', row.find('input[name=live_id]').val());
    formData.append('title', row.find('input[name=title]').val());
    formData.append('date', row.find('input[name=date]').val());
    formData.append('date_from', row.find('input[name=date_from]').val());
    formData.append('date_to', row.find('input[name=date_to]').val());
    formData.append('speaker', row.find('input[name=speaker]').val());
    formData.append('text', row.find('textarea[name=text]').val());

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/update-live',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            button.text('Ждите...');
            button.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    if (typeof data.message !== 'undefined')
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
            button.text(buttonText);
            button.removeAttr('disabled');
        }
    });
}

function deleteLive(row) {
    var data = {'id': row.find('input[name=live_id]').val()}

    request({
        url: document.location.pathname + '/delete-live',
        method: 'post',
        data: data,
        success: function (data) {
            row.remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: row.find('.btn-cancel-black')
    });
}

function addLive(row) {
    if (row.find('input[name=title]').val() == '')
        return inputError(row.find('input[name=title]'));
    if (row.find('input[name=date]').val() == '')
        return inputError(row.find('input[name=date]'));
    if (row.find('input[name=date_from]').val() == '')
        return inputError(row.find('input[name=date_from]'));
    if (row.find('input[name=date_to]').val() == '')
        return inputError(row.find('input[name=date_to]'));
    if (row.find('input[name=speaker]').val() == '')
        return inputError(row.find('input[name=speaker]'));
    if (row.find('textarea[name=text]').val() == '')
        return inputError(row.find('textarea[name=text]'));

    var button = row.find('.btn-save');
    var buttonText = button.text();

    var formData = new FormData(row.find('form')[0]);
    formData.append('title', row.find('input[name=title]').val());
    formData.append('date', row.find('input[name=date]').val());
    formData.append('date_from', row.find('input[name=date_from]').val());
    formData.append('date_to', row.find('input[name=date_to]').val());
    formData.append('speaker', row.find('input[name=speaker]').val());
    formData.append('text', row.find('textarea[name=text]').val());

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-live',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            button.text('Ждите...');
            button.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    row.before(data.html);
                    row.find('input[name=title]').val('');
                    row.find('input[name=date]').val('');
                    row.find('input[name=date_from]').val('');
                    row.find('input[name=date_to]').val('');
                    row.find('input[name=speaker]').val('');
                    row.find('textarea[name=text]').val('');
                    row.find('.thumbnail_div input').val('');
                    row.find('.thumbnail_div span').css('display', 'inherit');
                    row.find('.thumbnail_div img').css('display', 'none');
                    row.find('.image__delete').css('display', 'none');
                    litepickerRestart();
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            button.text(buttonText);
            button.removeAttr('disabled');
        }
    });
}

function readLocalImage(input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function saveMainSchedule(form) {
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
    var button = form.find('.btn-save');
    var buttonText = button.text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-main-schedule',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            button.text('Ждите...');
            button.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    if (typeof data.message !== 'undefined')
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
            button.text(buttonText);
            button.removeAttr('disabled');
        }
    });
}