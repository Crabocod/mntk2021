$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        recoveryPassword($(this));
    });
});

function recoveryPassword(form) {
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
        url: '/recovery',
        method: 'post',
        data: form.serializeArray(),
        button: form.find('button'),
        success: function(data) {
            document.location.href = '/auth';
        },
        error: function(data) {
            errorModal(data.message);
        },
    });
}