$('textarea#full_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('short_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
    setEditor(document.getElementById('full_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('form#save-event').submit(function (e) {
        e.preventDefault();
        saveEventAbout($(this));
    });

    $('body').on('change', '#file-1', function (e) {
        $(this).closest('div').find('span').text($(this).val().split('/').pop().split('\\').pop());
    });

    $('body').on('click', '.expot-exl:not([disabled])', function (e) {
        e.preventDefault();
        getUsersExcel($(this));
    });
});

function saveEventAbout(form) {
    var inputWithError = undefined;
    form.find('input,textarea').each(function () {
        if ($(this).hasClass('required')) {
            if ($(this).val() == '') {
                inputWithError = $(this);
                return false;
            }
        }
    });
    if (typeof inputWithError === 'object')
        return inputError(inputWithError);

    var formData = new FormData(form.get(0));

    var date = new Date(formData.get('date').replace(/(\d{2})\.(\d{2})\.(\d{4})/, '$3-$2-$1'));
    var dateTime = date.format('yyyy-mm-dd')+' '+formData.get('time')+':00';
    formData.set('date', dateTime);

    formData.set('show_button', (formData.get('show_button') === 'on') ? 1 : 0);

    var buttonText = form.find('.btn-save-green').text();

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-event-about',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.btn-save-green').text('Ждите...');
            form.find('.btn-save-green').attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    successModal(data.message);
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            form.find('.btn-save-green').text(buttonText);
            form.find('.btn-save-green').removeAttr('disabled');
        }
    });
}

$(document).ready(function () {
    $(document).on('click', '.ajax-accept', function (e) {
        e.preventDefault();
        var el = $(this).closest('tr');
        var data = {};
        data['id'] = $(this).closest('tr').find('#user_id').val();
        data['status'] = 1;
        request({
            url: document.location.pathname + '/user-change-status',
            method: 'post',
            data: data,
            success: function (data) {
                console.log(data);
                el.replaceWith(data.html);
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    });

    $(document).on('click', '.ajax-decline', function (e) {
        e.preventDefault();
        var el = $(this).closest('tr');
        var data = {};
        data['id'] = $(this).closest('tr').find('#user_id').val();
        data['status'] = 2;
        request({
            url: document.location.pathname + '/user-change-status',
            method: 'post',
            data: data,
            success: function (data) {
                console.log(data);
                el.replaceWith(data.html);
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    });

    $(document).on('click', '.ajax-delete', function (e) {
        e.preventDefault();
        confirmModal();
        var data = {};
        data['id'] = $(this).closest('.btns-control').find('#event_id').val();
        confirmationConfirmModal = function () {
            request({
                url: document.location.pathname + '/event-delete',
                method: 'post',
                data: data,
                success: function (data) {
                    closeSuccessModal = function () {
                        window.location.href = data.href;
                    }
                    successModal(data.message);
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        };
    });
});

function getUsersExcel(elem) {
    var buttonText = elem.text();
    var buttonWidth = elem.css('width');

    $.ajax({
        type: 'POST',
        url: document.location.pathname + '/get-users-excel',
        data: {},
        dataType: 'json',
        beforeSend: function (jqXHR, textStatus) {
            elem.css('width', buttonWidth);
            elem.text('Ждите...');
            elem.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                var $a = $("<a>");
                $a.attr("href", data);
                $("body").append($a);
                $a.attr("download", "users.xlsx");
                $a[0].click();
                $a.remove();
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            elem.css('width', '');
            elem.text(buttonText);
            elem.removeAttr('disabled');
        }
    });
}