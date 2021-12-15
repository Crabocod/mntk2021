$(document).ready(function() {
    $(document).on('submit', 'form#comment', function(e) {
        e.preventDefault();
        addFeedback($(this));
    });
});

function getFeedbacks(){
    request({
        url: document.location.pathname+'/get-feedback',
        method: 'post',
        success: function(data) {
            $('.new-reviews_blocks').remove();
            $('.theme-block').after(data.html);
        },
        error: function(data) {
            errorModal(data.message);
        },
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
            getFeedbacks();
        },
        error: function(data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}