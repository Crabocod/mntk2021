$(document).ready(function () {
    $('form#save_section').submit(function (e) {
        e.preventDefault();
        saveSection($(this));
    });

    $('body').on('click', '#save_section .btn-save:not([disabled])', function (e) {
        e.preventDefault();
        saveSection($(this).closest('form'));
    });

    $('body').on('click', '#delete_section:not([disabled])', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteSection(form);
        };
    });

    $('body').on('click', 'tr[section_feedback_id] .btn-cancel', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr[section_feedback_id]');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteSectionFeedback(row);
        };
    });

    $('body').on('click', '.update-section-jury .btn-save', function (e) {
        e.preventDefault();
        updateSectionJury($(this).closest('form'));
    });

    $('body').on('click', '.update-section-jury .btn-cancel', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteSectionJury(form);
        };
    });

    $('body').on('click', '#add-section-jury .btn-save', function (e) {
        e.preventDefault();
        addSectionJury($(this).closest('form'));
    });

    $('body').on('change', 'input#add-photo', function(e) {
        e.preventDefault();
        addSectionImage($(this).closest('form'));
    });

    $('body').on('click', '.admin-photos__delete', function(e) {
        e.preventDefault();
        deleteSectionImage($(this));
    });

    $('.sortable-images').sortable({
        filter: '.disabled',
        onMove: event => {
            return !event.related.classList.contains('disabled');
        },
        onUpdate: function (evt) {
            sortSectionImages();
        }
    });
});

function saveSection(form) {
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
        url: document.location.pathname + '/save-section',
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

function deleteSection(form) {
    var data = {
        'id': form.find('input[name=id]').val()
    }

    request({
        url: document.location.pathname + '/delete-section',
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
        button: form.find('#delete_section')
    });
}

function deleteSectionFeedback(row) {
    var data = {
        'id': row.attr('section_feedback_id')
    }

    request({
        url: document.location.pathname + '/delete-section-feedback',
        method: 'post',
        data: data,
        success: function (data) {
            row.remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: row.find('.btn-cancel')
    });
}

function updateSectionJury(form) {
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
        url: document.location.pathname + '/save-jury',
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

function addSectionJury(form) {
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
        url: document.location.pathname + '/save-jury',
        method: 'post',
        data: data,
        success: function (data) {
            form.before(data.html);
            form.trigger('reset');
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-save')
    });
}

function deleteSectionJury(form) {
    var data = {
        id: form.find('input[name=id]').val()
    }

    request({
        url: document.location.pathname + '/delete-jury',
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

function addSectionImage(form) {
    // Сортировка
    var sort_num = 1;
    $('div[section_image_id]').each(function() {
        sort_num++;
    });

    var formData = new FormData(form.get(0));
    formData.append('sort_num', sort_num);

    var buttonText = form.find('span').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-image',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('span').text('Ждите...');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    form.before(data.html);
                    form.find('input').val('');
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
        }
    });
}

function deleteSectionImage(button) {
    var data = {
        id: button.closest('div[section_image_id]').attr('section_image_id')
    }

    request({
        url: document.location.pathname + '/delete-image',
        method: 'post',
        data: data,
        success: function (data) {
            button.closest('div[section_image_id]').remove();
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function sortSectionImages() {
    var sort = [];
    var i = 1;
    $('[section_image_id]').each(function() {
        sort.push({
            'section_image_id': $(this).attr('section_image_id'),
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