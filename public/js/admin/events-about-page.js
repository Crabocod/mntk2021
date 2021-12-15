$('textarea#about_speaker').ready(function() {
    setEditor(document.getElementById('about_speaker'), {
        url: '/admin/save-ckeditor-image',
    });
});

$('textarea#full_text').ready(function() {
    setEditor(document.getElementById('full_text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function() {
    $('form#update_event').submit(function (e) {
        e.preventDefault();
        updateEvent($(this));
    });

    $('body').on('change', '#update_event input[type=file]', function (e) {
        e.preventDefault();
        $(this).siblings('.btn').find('span').text(this.files[0].name);
    });

    $('body').on('click', '.delete-event', function (e) {
        e.preventDefault();
        confirmModal();
        confirmationConfirmModal = function() {
            deleteEvent();
        };
    });

    $('body').on('click', 'form#update_enent_user .js-allow-user', function (e) {
        e.preventDefault();
        confirmUser($(this), {
            'user_id': $(this).parent().attr('user_id'),
            'status': 1
        });
    });

    $('body').on('click', 'form#update_enent_user .js-disallow-user', function (e) {
        e.preventDefault();
        confirmUser($(this), {
            'user_id': $(this).parent().attr('user_id'),
            'status': 2
        });
    });

    $('.sortable-images').sortable({
        filter: '.disabled',
        onMove: event => {
            return !event.related.classList.contains('disabled');
        },
        onUpdate: function (evt) {
            sortImages();
        }
    });

    $('body').on('change', 'input#add-photo', function(e) {
        e.preventDefault();
        addImage($(this).closest('form'));
    });

    $('body').on('click', '.sortable-images .delete-photo', function(e) {
        e.preventDefault();
        deleteImage($(this));
    });
});

function deleteEvent() {
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

function updateEvent(form) {
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

function confirmUser(elem, reqData) {
    request({
        url: document.location.pathname+'/confirm-user',
        method: 'post',
        data: reqData,
        success: function(data) {
            if(reqData.status === 1) {
                elem.parent().find('.js-disallow-user').show();
                elem.parent().find('.js-allow-user').hide();
            } else {
                elem.parent().find('.js-disallow-user').hide();
                elem.parent().find('.js-allow-user').show();
            }
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

function addImage(form) {
    var formData = new FormData(form.get(0));
    var buttonText = form.find('span').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-image',
        data: formData,
        processData: false,
        contentType: false,
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    form.find('.photo-add').before(data.html);
                    form.find('input').val('');
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        }
    });
}

function deleteImage(button) {
    var data = {
        id: button.closest('[data-id]').attr('data-id')
    }

    request({
        url: document.location.pathname + '/delete-image',
        method: 'post',
        data: data,
        success: function (data) {
            button.closest('div[data-id]').remove();
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function sortImages() {
    var sort = [];
    var i = 1;
    $('.sortable-images [data-id]').each(function() {
        sort.push({
            'id': $(this).attr('data-id'),
            'sort_num': i
        });
        i++;
    });

    request({
        url: document.location.pathname + '/sort-images',
        method: 'post',
        data: {sort: sort},
        success: function (data) {
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}