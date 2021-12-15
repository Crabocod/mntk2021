$('textarea#news-textarea').ready(function() {
    setEditor(document.getElementById('news-textarea'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function (){
    showNews();

    $(document).on('click', '.js-delete', function (e){
        e.preventDefault();
        var data = {
            'id': $(this).attr('data-id')
        }

        confirmModal();
        confirmationConfirmModal = function () {
            request({
                url: '/admin/news/delete-news',
                method: 'post',
                data: data,
                success: function (data) {
                    showNews();
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });

    $(document).on('submit', '.add-news', function(e) {
        e.preventDefault();
        addNews($(this));
    });
});

function showNews() {
    request({
        url: document.location.pathname + '/show-news',
        method: 'post',
        success: function (data) {
            $('.border-table .row-form').remove();
            $('.border-table').append(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        },
    });
}

function addNews(form){
    if (form.find('input[name=img_link]').val() == '')
        return errorModal('Необходимо добавить обложку новости');
    if (form.find('input[name=iframe]').val() == '')
        return inputError(form.find('input[name=iframe]'));
    if (form.find('input[name=date]').val() == '')
        return inputError(form.find('input[name=date]'));
    if (form.find('input[name=title]').val() == '')
        return inputError(form.find('input[name=title]'));
    if (form.find('textarea[name=text]').val() == '')
        return ckeditorError(form.find('.ck-editor__editable'));

    var formData = new FormData(form.get(0));
    let btn = form.find('.btn-submit');
    var buttonText = btn.text();


    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-news',
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
                    showNews();
                    successModal(data.message);
                    form.find('input[name=title]').val('');
                    form.find('textarea[name=text]').val('');
                    form.find('input[name=date]').val('');
                    form.find('input[name=img_link]').val('');
                    form.find('input[name=iframe]').val('');
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