$(document).ready(function() {
    $(document).on('click', '.programs-btn', function(e) {
        e.preventDefault();
        addFeedback($(this).closest('form'));
    });
});

function addFeedback(form) {
    if(form.find('textarea[name=text]').val() === '')
        return inputError(form.find('textarea[name=text]'));

    let data = {}
    data.text = form.find('textarea').val();
    if(form.find('.grade-block.active').length > 0)
        data.grade = form.find('.grade-block.active').attr('data-grade');

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