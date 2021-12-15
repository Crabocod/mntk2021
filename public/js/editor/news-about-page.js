$('textarea#full_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);
    setEditor(document.getElementById('short_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
    setEditor(document.getElementById('full_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('form#save-news').submit(function (e) {
        e.preventDefault();
        save($(this));
    });

    $('body').on('click', 'form#save-news .btn-cancel:not([disabled])', function(e) {
        e.preventDefault();
        confirmModal();
        var form = $(this).closest('form');
        confirmationConfirmModal = function () {
            deleteNews(form);
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
        url: document.location.pathname+'/save-news',
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

function deleteNews(form) {
    var data = {
        'id' : form.find('input[name=id]').val()
    }
    request({
        url: document.location.pathname+'/delete-news',
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
        button: form.find('.btn-save')
    });
}