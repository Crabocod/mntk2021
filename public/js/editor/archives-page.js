$(document).ready(function () {
    $('form#add_archive').submit(function (e) {
        e.preventDefault();
        add($(this));
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
        url: document.location.pathname+'/save-archive',
        method: 'post',
        data: data,
        success: function (data) {
            if(typeof data.url != 'undefined')
                document.location.href = data.url;
            form.find('input[name=title]').val('');
            form.find('input[name=date]').val('');
            $('#archives .tr-head').after(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}