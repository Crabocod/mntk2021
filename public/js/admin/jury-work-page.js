$(document).ready(function() {
    $(document).on('submit', 'form#add-jury-work', function(e) {
        e.preventDefault();
        addJuryWork($(this));
    });
});

function addJuryWork(form) {
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
        'title': form.find('[name=title]').val(),
        'number': form.find('[name=number]').val(),
        'date_from': form.find('[name=date_from]').val()+' '+form.find('[name=time_from]').val()+':00'
    }

    request({
        url: '/admin/jury-work/add',
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