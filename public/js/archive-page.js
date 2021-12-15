$(document).ready(function () {
    $('form#add-feedback').submit(function (e) {
        e.preventDefault();
        addFeedback($(this));
    });
});

function addFeedback(form) {
    if(form.find('textarea[name=text]').val() == '')
        return inputError(form.find('textarea[name=text]'));

    request({
        url: document.location.pathname+'/add-feedback',
        method: 'post',
        data: form.serializeArray(),
        success: function(data) {
            $('#section_feedbacks').append(data.html);
        },
        error: function(data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}