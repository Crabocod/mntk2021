$(document).ready(function() {
    $(document).on('click', '.js-sign-up', function(e) {
        e.preventDefault();
        if($(this).attr('disabled') !== 'disabled')
            signUp();
    });

    $(document).on('submit', 'form#comment', function(e) {
        e.preventDefault();
        addFeedback($(this));
    });
});

function signUp() {
    request({
        url: document.location.pathname+'/signup',
        method: 'post',
        data: {},
        success: function(data) {
            $('.js-sign-up').text('ВЫ ЗАПИСАНЫ');
            $('.js-sign-up').attr('disabled', 'disabled');
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}

function addFeedback(form) {
    if(form.find('textarea[name=text]').val() === '')
        return inputError(form.find('textarea[name=text]'));
    let data = form.serializeArray()

    if (form.find('a.like').hasClass('active')){
        data.push({
            name: 'grade',
            value: '1'
        });
    } else if (form.find('a.dislike').hasClass('active')){
        data.push({
            name: 'grade',
            value: '2'
        });
    }

    request({
        url: document.location.pathname+'/add-feedback',
        method: 'post',
        data: data,
        success: function(data) {
            successModal(data.message);
            if(data.html !== undefined)
                $('#feedback_rows').append(data.html);
        },
        error: function(data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}