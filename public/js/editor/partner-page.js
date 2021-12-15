$('textarea#wtb_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('wtb_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('form#wtb-text').submit(function (e) {
        e.preventDefault();
        editWtb($(this));
    });

    $('body').on('change', '.add-icon-row input', function (e) {
        e.preventDefault();
        readLocalImage(this, $(this).siblings('img.icon'));
    });

    $('body').on('click', '.add-icon-row .icon__delete', function (e) {
        e.preventDefault();
        $(this).siblings('input[name=deleted_icon]').val(1);
        $(this).siblings('input[name=img_link]').val('');
        $(this).siblings('img.icon').attr('src', '/img/icon-demo.svg');
    });

    $('body').on('change', '#add-icon input', function (e) {
        e.preventDefault();
        $(this).siblings('img.icon').css('display', 'inherit');
        $(this).siblings('span').css('display', 'none');
        $(this).siblings('img.icon__delete').css('display', 'inherit');
        readLocalImage(this, $(this).siblings('img.icon'));
    });

    $('body').on('click', '#add-row .icon__delete', function (e) {
        e.preventDefault();
        $(this).siblings('img.icon').css('display', 'none');
        $(this).siblings('span').css('display', 'inherit');
        $(this).siblings('input').val('');
        $(this).css('display', 'none');
    });

    $('body').on('click', '.ajax-save', function (e) {
        e.preventDefault();
        var el = $(this);
        var buttonText = $(this).text();
        if($(this).closest('tr').find('.text')[0].value == '')
            return inputError($(this).closest('tr').find('.text'));

        var formData = new FormData($(this).closest('tr').find('.icon')[0]);
        formData.append('text', $(this).closest('tr').find('.text').val());

        $.ajax({
            type: 'post',
            url: document.location.pathname + '/save-member-group',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (jqXHR, textStatus) {
                el.text('Ждите...');
                el.attr('disabled', 'disabled');
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
                el.text(buttonText);
                el.removeAttr('disabled');
            }
        });
    });

    $('body').on('click', '.ajax-delete', function (e) {
        e.preventDefault();
        confirmModal();
        var el = $(this).closest('tr');
        var data = {};
        data['id'] = $(this).closest('tr').find('.icon')[0]['id'].value;
        confirmationConfirmModal = function () {
            request({
                url: document.location.pathname+'/delete-member-group',
                method: 'post',
                data: data,
                success: function (data) {
                    el.remove();
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        };
    });

    $('body').on('click', '.ajax-add', function (e) {
        e.preventDefault();
        var el = $(this);
        var buttonText = $(this).text();
        var tr  = $(this).closest('tr');
        if($(this).closest('tr').find('.text')[0].value == '')
            return inputError($(this).closest('tr').find('.text'));

        var formData = new FormData($(this).closest('tr').find('.icon')[0]);
        formData.append('text', $(this).closest('tr').find('.text').val());

        $.ajax({
            type: 'post',
            url: document.location.pathname + '/save-member-group',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function (jqXHR, textStatus) {
                el.text('Ждите...');
                el.attr('disabled', 'disabled');
            },
            statusCode: {
                200: function (data) {
                    if (data.status === 'ok') {
                        $('#add-row').before(data.html);
                        tr.find('.text').val('');
                        tr.find('input').val('');
                        tr.find('#add-icon img').css('display', 'none');
                        tr.find('#add-icon span').css('display', 'inherit');
                    } else if (data.status === 'error') {
                        errorModal(data.message);
                    }
                },
                403: function () {
                    alert("Доступ запрещен! Пожалуйста, обновите страницу.")
                }
            },
            complete: function (jqXHR, textStatus) {
                el.text(buttonText);
                el.removeAttr('disabled');
            }
        });
    });
});

function editWtb(form){
    var inputWithError = undefined;
    form.find('input,textarea').each(function () {
        if ($(this).hasClass('required')) {
            if ($(this).val() == '') {
                inputWithError = $(this);
                return false;
            }
        }
    });
    if (typeof inputWithError === 'object')
        return inputError(inputWithError);
    if(form.find('textarea').val() == '')
        return ckeditorError(form.find('.ck-editor__editable'));
    var formData = form.serializeArray();

    request({
        url: document.location.pathname + '/edit-wtb',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status === 'ok') {
                successModal(data.message);
            } else if (data.status === 'error') {
                errorModal(data.message);
            }
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-save-green')
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