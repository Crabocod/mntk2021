$(document).ready(function() {
    $(document).on('click', '.js-delete', function (e){
        e.preventDefault();
        confirmModal();
        confirmationConfirmModal = function() {
            deleteSection();
        }
    });

    $(document).on('submit', '.add-jury', function (e){
        e.preventDefault();
        addJury($(this));
    });

    $(document).on('click', '.delete-jury', function (e){
        e.preventDefault();
        var _this = $(this);
        confirmModal();
        confirmationConfirmModal = function() {
            deleteJury(_this.closest('form'));
        }
    });

    $(document).on('submit', '.save-jury', function (e){
        e.preventDefault();
        saveJury($(this));
    });

    $(document).on('submit', 'form#update_section', function(e) {
        e.preventDefault();
        updateSection($(this));
    });

    $('body').on('change', '#update_section input[type=file]', function (e) {
        e.preventDefault();
        $(this).siblings('.btn').find('span').text(this.files[0].name);
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

function deleteSection(){
    request({
        url: document.location.pathname+'/delete-section',
        method: 'post',
        success: function(data) {
            document.location.href = '/admin/jury-work';
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

function addJury(form){
    request({
        url: document.location.pathname+'/add-jury',
        method: 'post',
        data: form.serializeArray(),
        success: function(data) {
            successModal(data.message);
            $('.add-jury').before(data.html);
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

function deleteJury(form){
    var data = {
        'id': form.find('input[name=id]').val()
    }

    request({
        url: document.location.pathname+'/delete-jury',
        method: 'post',
        data: data,
        success: function(data) {
            successModal(data.message);
            form.remove();
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

function saveJury(form){
    request({
        url: document.location.pathname+'/save-jury',
        method: 'post',
        data: form.serializeArray(),
        success: function(data) {
            successModal(data.message);
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

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

function updateSection(form) {
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