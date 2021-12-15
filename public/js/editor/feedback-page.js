$('textarea#gf_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('gf_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('form#save-feedback').submit(function (e) {
        e.preventDefault();
        saveFeedback($(this));
    });

    $('body').on('change', 'input#add-photo', function(e) {
        e.preventDefault();
        addFeedbackImage($(this).closest('form'));
    });

    $('body').on('click', '.admin-photos__delete', function(e) {
        e.preventDefault();
        deleteFeedbackImage($(this));
    });

    $('.sortable-images').sortable({
        filter: '.disabled',
        onMove: event => {
            return !event.related.classList.contains('disabled');
        },
        onUpdate: function (evt) {
            sortFeedbackImages();
        }
    });
});

function saveFeedback(form) {
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
        url: document.location.pathname + '/save',
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

function addFeedbackImage(form) {
    var formData = new FormData(form.get(0));
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

function deleteFeedbackImage(button) {
    var data = {
        id: button.closest('div[feedback_image_id]').attr('feedback_image_id')
    }

    request({
        url: document.location.pathname + '/delete-image',
        method: 'post',
        data: data,
        success: function (data) {
            button.closest('div[feedback_image_id]').remove();
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function sortFeedbackImages() {
    var sort = [];
    var i = 1;
    $('[feedback_image_id]').each(function() {
        sort.push({
            'google_form_img_id': $(this).attr('feedback_image_id'),
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