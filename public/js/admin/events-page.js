$(document).ready(function() {
    $(document).on('submit', 'form#save-event', function(e) {
        e.preventDefault();
        addEvent($(this));
    });
});

function addEvent(form) {
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

    var data = {
        'event_type_id': form.find('[name=event_type_id]').val(),
        'title': form.find('[name=title]').val(),
        'speaker': form.find('[name=speaker]').val(),
        'date_from': form.find('[name=date_from]').val()+' '+form.find('[name=time_from]').val()+':00'
    }

    request({
        url: '/admin/events/add',
        method: 'post',
        data: data,
        button: form.find('button'),
        success: function(data) {
            if(data.url !== undefined)
                document.location.href = data.url
        },
        error: function(data) {
            errorModal(data.message);
        }
    });
}