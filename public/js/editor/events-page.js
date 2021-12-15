$(document).ready(function () {
    $('form#event-add').submit(function (e) {
        e.preventDefault();
        saveEvent($(this));
    });
});

function saveEvent(form){
    var inputWithError = undefined;
    form.find('input').each(function () {
        if ($(this).hasClass('required')) {
            if ($(this).val() == '') {
                inputWithError = $(this);
                return false;
            }
        }
    });
    if (typeof inputWithError === 'object')
        return inputError(inputWithError);

    var formData = form.serializeArray();

    request({
        url: document.location.pathname + '/save-event',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status === 'ok') {
                if(typeof data.url !== 'undefined')
                    document.location.href = data.url;
                $('#event-add')[0].reset();
                $('.table-head').after(data.html);
            } else if (data.status === 'error') {
                errorModal(data.message);
            }
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.ajax-add')
    });
}