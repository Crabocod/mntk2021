$(document).ready(function () {
    $('form#auth').submit(function (e) {
        e.preventDefault();
        auth($(this));
    });

    $('form#password_recovery').submit(function (e) {
        e.preventDefault();
        recoveryPassword($(this));
    });
});

function auth(form) {
    if(form.find('input[name=email]').val() == '')
        return inputError(form.find('input[name=email]'));
    if(form.find('input[name=password]').val() == '')
        return inputError(form.find('input[name=password]'));
    if(form.find('select[name=conference_url]').val() == 0)
        return inputError(form.find('select[name=conference_url]'));

    var data = form.serializeArray();
    data.push({name: 'timezone', value: jstz.determine().name()});

    request({
        url: '/editor/auth/login',
        method: 'post',
        data: data,
        success: function(data) {
            document.location.href = data.url
        },
        error: function(data) {
            $('#js-error-message').css('display', 'block');
            $('#js-error-message').html(data.message);
        },
        button: form.find('.btn-submit')
    });
}

function recoveryPassword(form) {
    if(form.find('input[name=email]').val() == '')
        return inputError(form.find('input[name=email]'));

    request({
        url: '/editor/auth/recovery-password',
        method: 'post',
        data: form.serializeArray(),
        success: function(data) {
            var inst = $('[data-remodal-id=result-recovery-pass]').remodal();
            inst.open();
        },
        error: function(data) {
            var inst = errorModal(data.message);
            closeErrorModal = function () {
                var inst = $('[data-remodal-id=recovery-pass]').remodal();
                inst.open();
            }
        },
        button: form.find('.btn-submit')
    });
}