$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();
        registration($(this));
    });

    MaskedPhone();
});

function registration(form) {
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

    if(form.find('[name=password]').val() !== form.find('[name=confirm_password]').val())
        return inputError(form.find('[name=confirm_password]'));

    if(form.find(form.find('[name=chb-confirm-1]')).prop('checked') === false)
        return errorModal('Чтобы пользоваться нужно согласиться с правилами');

    var data = {}
    data.full_name = form.find('[name=full_name]').val();
    data.email = form.find('[name=email]').val();
    data.phone = form.find('[name=phone]').val().replace(/[^+\d]/g, '');
    data.password = form.find('[name=password]').val();
    data.timezone = jstz.determine().name();

    request({
        url: document.location.pathname+'/register',
        method: 'post',
        data: data,
        button: form.find('button'),
        success: function(data) {
            successModal(data.message);
            closeSuccessModal = function() {
                document.location.href = '/auth';
            }
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}