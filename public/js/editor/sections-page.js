$(document).ready(function () {
    $('form#add_section').submit(function (e) {
        e.preventDefault();
        add($(this));
    });

    $('body').on('change', 'input[name=is_publication]', function (e) {
        e.preventDefault();
        publication($(this));
    });

    $('body').on('click', '#sectons .tr-link td:not(.td-checkbox)', function (e) {
        e.preventDefault();
        document.location.href = document.location.pathname+'/'+$(this).closest('tr').attr('section_id');
    });
});

function add(form) {
    var inputWithError = undefined;
    form.find('input,select,textarea').each(function () {
        if ($(this).hasClass('required')) {
            if ((($(this).is('select') || $(this).is('input[type=number]')) && $(this).val() == 0) || $(this).val() == '') {
                inputWithError = $(this);
                return false;
            }
        }
    });
    if (typeof inputWithError === 'object')
        return inputError(inputWithError);

    var data = form.serializeArray();

    request({
        url: document.location.pathname + '/save-section',
        method: 'post',
        data: data,
        success: function (data) {
            if(typeof data.url != 'undefined')
                document.location.href = data.url;
            form.find('input[name=title_1]').val('');
            form.find('input[name=title_2]').val('');
            form.find('input[name=protection_date]').val('');
            $('#sectons .tr-head').after(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-submit')
    });
}

function publication(input) {
    var data = {
        is_publication: (input.prop("checked")) ? 1 : 0,
        id: input.closest('[section_id]').attr('section_id')
    }

    request({
        url: document.location.pathname + '/publication',
        method: 'post',
        data: data,
        success: function (data) {},
        error: function (data) {
            errorModal(data.message);
        }
    });
}