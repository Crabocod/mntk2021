$(document).ready(function () {
    $('form#auth').submit(function (e) {
        e.preventDefault();
        auth($(this));
    });
});

function auth(form) {
    var inputWithError = undefined;
    form.find('.required').each(function() {
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
    data.push({name: 'timezone', value: jstz.determine().name()});

    request({
        url: document.location.pathname+'/login',
        method: 'post',
        data: data,
        button: form.find('button'),
        success: function(data) {
            document.location.href = data.url
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}