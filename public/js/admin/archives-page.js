$(document).ready(function() {
    $(document).on('submit', 'form#save-archive', function(e) {
        e.preventDefault();
        addArchive($(this));
    });

    $(document).on('click', '.checkbox label', function(e) {
         e.preventDefault();
         let input = $(this).parent().find('input');
         if(input.prop('checked'))
             input.prop('checked', false);
         else
             input.prop('checked', true);

        let publication = ($(this).parent().find('input').prop('checked')) ? 1 : 0;
        publicationArchive($(this).closest('[data-id]').attr('data-id'), publication);
    });

    $(document).on('click', '.archive-table .row-form', function(e) {
        if($(e.target).is('label') === false && $(this).is('input') === false) {
            e.preventDefault();
            document.location.href = '/admin/archive/' + $(this).closest('[data-id]').attr('data-id');
        }
    });
});

function addArchive(form) {
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
        'speaker': form.find('[name=speaker]').val(),
        'date_from': form.find('[name=date_from]').val()+' '+form.find('[name=time_from]').val()+':00'
    }

    request({
        url: '/admin/archive/add',
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

function publicationArchive(id, publication) {
    request({
        url: '/admin/archive/publication',
        method: 'post',
        data: {'id': id, 'is_published': publication},
        success: function(data) {},
        error: function(data) {
            errorModal(data.message);
        }
    });
}