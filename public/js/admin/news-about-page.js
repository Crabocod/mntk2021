$('textarea#news-textarea').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('news-textarea'), {
        url: '/admin/save-ckeditor-image',
    });
});

$('textarea#news-textarea-full').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('news-textarea-full'), {
        url: '/admin/save-ckeditor-image',
    });
});


$(document).ready(function (){
    $('.js-delete').on('click', function (e){
        e.preventDefault();
        var data = {
            'id': $(this).closest('form').find('input[name=id]').val()
        }

        confirmModal();
        confirmationConfirmModal = function () {
            request({
                url: '/admin/news/delete-news',
                method: 'post',
                data: data,
                success: function (data) {
                    location.href = '/admin/news';
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        }
    });

    $('.add-news').on('submit', function (e){
        e.preventDefault();
        addNews($(this));
    });
});

function addNews(form){
    if (form.find('textarea[name=text]').val() == '')
        return inputError(form.find('textarea[name=text]'));
    if (form.find('textarea[name=full_text]').val() == '')
        return inputError(form.find('textarea[name=full_text]'));
    if (form.find('input[name=title]').val() == '')
        return inputError(form.find('input[name=title]'));
    if (form.find('input[name=date]').val() == '')
        return inputError(form.find('input[name=date]'));
    if (form.find('input[name=iframe]').val() == '')
        return inputError(form.find('input[name=iframe]'));

    var formData = new FormData(form.get(0));
    let btn = form.find('.btn-submit');
    var buttonText = btn.text();


    $.ajax({
        type: 'post',
        url: '/admin/news/save-news',
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
            btn.text(buttonText);
            btn.removeAttr('disabled');
        }
    });
}