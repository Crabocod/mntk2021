$('textarea#gr_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('gr_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('form#save-main').submit(function (e) {
        e.preventDefault();
        saveMain($(this));
    });

    $('form#save-gr').submit(function (e) {
        e.preventDefault();
        saveGR($(this));
    });

    $('form#save-barrels').submit(function (e) {
        e.preventDefault();
        saveBarrels($(this));
    });

    $('body').on('change', '#file-2', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
    });

    $('body').on('click', '#add-chess .btn-save', function (e) {
        e.preventDefault();
        addChess($(this).closest('form'));
    });

    $('body').on('click', '#add-chess .add-icon-row .icon__delete', function (e) {
        e.preventDefault();
        $(this).siblings('img.icon').css('display', 'none');
        $(this).siblings('span').css('display', 'inherit');
        $(this).siblings('input').val('');
        $(this).css('display', 'none');
    });

    $('body').on('change', '#add-chess .add-icon-row input', function (e) {
        e.preventDefault();
        $(this).siblings('img.icon').css('display', 'inherit');
        $(this).siblings('span').css('display', 'none');
        $(this).siblings('img.icon__delete').css('display', 'inherit');
        readLocalImage(this, $(this).siblings('img.icon'));
    });

    $('body').on('click', '.chess-row .btn-cancel', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteChess(form);
        };
    });

    $('body').on('click', '.chess-row .btn-save', function (e) {
        e.preventDefault();
        updateChess($(this).closest('form'));
    });

    $('body').on('click', '.chess-row .icon__delete', function (e) {
        e.preventDefault();
        $(this).siblings('input[name=deleted_icon]').val(1);
        $(this).siblings('input[name=img_link]').val('');
        $(this).siblings('img.icon').attr('src', '/img/shahmatka.svg');
    });

    $('body').on('change', '.chess-row .add-icon-row input', function (e) {
        e.preventDefault();
        readLocalImage(this, $(this).siblings('img.icon'));
    });

    $('body').on('change', '#file-1', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
    });

    $('body').on('click', '#block-statuses a.btn-save', function (e) {
        e.preventDefault();
        $(this).siblings('input[type=hidden]').val(1);
        updateBlockStatus($(this));
    });

    $('body').on('click', '#block-statuses a.btn-delete', function (e) {
        e.preventDefault();
        $(this).siblings('input[type=hidden]').val(0);
        updateBlockStatus($(this));
    });

    $('body').on('submit', 'form#timer', function (e) {
        e.preventDefault();
        updateTimerDatetime($(this));
    });

    $('body').on('submit', 'form#ether_form', function (e) {
        e.preventDefault();
        updateEtherIframe($(this));
    });
});


function saveBarrels(form) {
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

    var data = form.serializeArray();

    request({
        url: document.location.pathname+'/save-barrels',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}

function saveMain(form) {
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
        url: document.location.pathname+'/save-conference',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}

function saveGR(form) {
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
    if(form.find('textarea').val() == '')
        return ckeditorError(form.find('.ck-editor__editable'));

    var formData = new FormData(form.get(0));
    var buttonText = form.find('.btn-submit').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-gr',
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

function addChess(form) {
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

    var date = formData.get('date');
    date = new Date(date.replace(/(\d{2})\.(\d{2})\.(\d{4})/, '$3-$2-$1'));
    var dateTime = date.format('yyyy-mm-dd')+' '+formData.get('time')+':00';
    formData.set('date', dateTime);

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-chess',
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

function updateChess(form) {
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

    var date = formData.get('date');
    date = new Date(date.replace(/(\d{2})\.(\d{2})\.(\d{4})/, '$3-$2-$1'));
    var dateTime = date.format('yyyy-mm-dd')+' '+formData.get('time')+':00';
    formData.set('date', dateTime);

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-chess',
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

function deleteChess(form) {
    var data = {'id' : form.find('input[name=id]').val()}

    request({
        url: document.location.pathname+'/delete-chess',
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

function updateBlockStatus(button) {
    var form = button.closest('form');

    request({
        url: document.location.pathname+'/save-conference',
        method: 'post',
        data: form.serializeArray(),
        success: function (data) {
            button.toggleClass('btn-save');
            button.toggleClass('btn-delete');
            if(button.hasClass('btn-save'))
                button.text('Показать');
            else
                button.text('Скрыть');
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function updateTimerDatetime(form) {
    var button = form.find('button');
    var timer_date = form.find('input[name=timer_date]').val();
    var timer_time = form.find('input[name=timer_time]').val();

    timer_date = new Date(timer_date.replace(/(\d{2})\.(\d{2})\.(\d{4})/, '$3-$2-$1'));
    var timer_datetime = timer_date.format('yyyy-mm-dd')+' '+timer_time+':00';

    request({
        url: document.location.pathname+'/save-conference',
        method: 'post',
        data: {timer_datetime: timer_datetime},
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}

function updateEtherIframe(form) {
    var button = form.find('button');

    request({
        url: document.location.pathname+'/save-conference',
        method: 'post',
        data: form.serializeArray(),
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
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