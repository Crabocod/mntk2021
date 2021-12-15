$(document).ready(function () {
    $('form#add_news').submit(function (e) {
        e.preventDefault();
        add($(this));
    });

    $('body').on('change', 'input[name=is_publication]', function (e) {
        e.preventDefault();
        publication($(this));
    });
});

function add(form) {
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
            if(typeof data.url != 'undefined')
                document.location.href = data.url;
            form.find('input[name=title]').val('');
            form.find('input[name=date]').val('');
            $('#news .tr-head').after(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}

function publication(input) {
    var data = {
        is_publication: (input.prop("checked")) ? 1 : 0,
        id: input.closest('[news_id]').attr('news_id')
    }

    request({
        url: document.location.pathname + '/publication',
        method: 'post',
        data: data,
        success: function (data) {},
        error: function (data) {
            errorModal(data.message);
        }
    });
}