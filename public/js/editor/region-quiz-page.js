$('textarea#region_quiz_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('region_quiz_text'), {
        url: '/editor/'+urlSegments[1]+'/save-ckeditor-image',
    });
});

$(document).ready(function () {
    $('body').on('submit', 'form#save-main', function (e) {
        e.preventDefault();
        saveRegionQuizText($(this));
    });

    $('body').on('change', 'input[name=visibility]', function (e) {
        e.preventDefault();
        publication($(this));
    });

    $('body').on('click', '.update-row .btn-save:not([disabled])', function (e) {
        e.preventDefault();
        update($(this).closest('tr'));
    });

    $('body').on('click', '#add-row .btn-save:not([disabled])', function (e) {
        e.preventDefault();
        add($(this).closest('tr'));
    });

    $('body').on('click', '.btn-cancel-black:not([disabled])', function (e) {
        e.preventDefault();
        var tr = $(this).closest('tr');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteQuestion(tr);
        };
    });

    $('body').on('click', '#expot-exl:not([disabled])', function (e) {
        e.preventDefault();
        getAnswersExcel();
    });

    $('body').on('click', '.toggle-list a:not([disabled])', function (e) {
        e.preventDefault();
        $(this).attr('disabled', 'disabled');
        var answers = $(this).siblings('div.hidden-toggle');
        if (answers.css('display') == 'none') {
            answers.slideDown({'duration': 400})
            $(this).text('скрыть...');
            $(this).removeClass('toggle-list__open');
            $(this).addClass('toggle-list__close');
        } else {
            answers.slideUp({'duration': 400});
            $(this).text('раскрыть...');
            $(this).addClass('toggle-list__open');
            $(this).removeClass('toggle-list__close');
        }
        $(this).removeAttr('disabled');
    });

    $('body').on('change', '.row-image input', function (e) {
        e.preventDefault();
        readLocalImage(this, $(this).siblings('img.image'));
        $(this).siblings('img.image').css('display', 'inherit');
        $(this).siblings('span').css('display', 'none');
        $(this).parent().siblings('img.image__delete').css('display', 'inherit');
    });

    $('body').on('click', '.row-image .image__delete', function (e) {
        e.preventDefault();
        var elem = $(this).siblings('.thumbnail_div');
        elem.find('img.image').css('display', 'none');
        elem.find('span').css('display', 'inherit');
        elem.find('input[name=img]').val('');
        elem.find('input[name=deleted_img]').val(1);
        $(this).css('display', 'none');
    });

    $('body').on('change', '.row-audio input', function (e) {
        e.preventDefault();
        if($(this).val() == '')
            return false;
        var fileName = $(this).val().split('/').pop().split('\\').pop();
        $(this).siblings('span').text(fileName);
        $(this).siblings('img.audio__delete').css('display', 'inherit');
    });

    $('body').on('click', '.row-audio .audio__delete', function (e) {
        e.preventDefault();
        $(this).siblings('span').text('Прикрепить аудио');
        $(this).siblings('input[name=audio]').val('');
        $(this).siblings('input[name=deleted_audio]').val(1);
        $(this).css('display', 'none');
    });
});

function saveRegionQuizText(form) {
    var data = form.serializeArray();

    request({
        url: document.location.pathname + '/save-main',
        method: 'post',
        data: data,
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('button.btn-save')
    });
}

function publication(input) {
    var data = {
        visibility: (input.prop("checked")) ? 1 : 0,
        id: input.closest('tr').find('input[name=questions_id]').val()
    }

    request({
        url: document.location.pathname + '/publication',
        method: 'post',
        data: data,
        success: function (data) {
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function update(row) {
    if (row.find('input[name=number]').val() == '')
        return inputError(row.find('input[name=number]'));

    var button = row.find('.btn-save');
    var buttonText = button.text();

    var formDataImage = new FormData(row.find('form')[0]);
    formDataImage.append('id', row.find('input[name=questions_id]').val());
    formDataImage.append('number', row.find('input[name=number]').val());
    formDataImage.append('youtube_iframe', row.find('input[name=youtube_iframe]').val());
    formDataImage.append('text', row.find('textarea[name=text]').val());

    var formDataImageAudio = new FormData(row.find('form')[1]);
    for (var pair of formDataImageAudio.entries()) {
        formDataImage.append(pair[0], pair[1]);
    }

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save',
        data: formDataImage,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            button.text('Ждите...');
            button.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    if (typeof data.message !== 'undefined')
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
            button.text(buttonText);
            button.removeAttr('disabled');
        }
    });
}

function deleteQuestion(row) {
    var data = {'id': row.find('input[name=questions_id]').val()}

    request({
        url: document.location.pathname + '/delete',
        method: 'post',
        data: data,
        success: function (data) {
            row.remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: row.find('.btn-cancel-black')
    });
}

function add(row) {
    if (row.find('input[name=number]').val() == '')
        return inputError(row.find('input[name=number]'));

    var button = row.find('.btn-save');
    var buttonText = button.text();

    var formData = new FormData(row.find('form')[0]);
    formData.append('number', row.find('input[name=number]').val());
    formData.append('youtube_iframe', row.find('input[name=youtube_iframe]').val());
    formData.append('text', row.find('textarea[name=text]').val());

    var formDataImageAudio = new FormData(row.find('form')[1]);
    for (var pair of formDataImageAudio.entries()) {
        formData.append(pair[0], pair[1]);
    }

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            button.text('Ждите...');
            button.attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    row.before(data.html);
                    row.find('input[name=number]').val('');
                    row.find('input[name=youtube_iframe]').val('');
                    row.find('textarea[name=text]').val('');
                    row.find('.thumbnail_div input').val('');
                    row.find('.thumbnail_div span').css('display', 'inherit');
                    row.find('.row-audio .thumbnail_div span').text('Прикрепить аудио');
                    row.find('.thumbnail_div img').css('display', 'none');
                    row.find('.image__delete').css('display', 'none');
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            button.text(buttonText);
            button.removeAttr('disabled');
        }
    });
}

function getAnswersExcel() {
    $.ajax({
        type: 'POST',
        url: document.location.pathname + '/get-excel',
        data: {},
        dataType: 'json'
    }).done(function (data) {
        var $a = $("<a>");
        $a.attr("href", data);
        $("body").append($a);
        $a.attr("download", "answers.xlsx");
        $a[0].click();
        $a.remove();
    });
}

function readLocalImage(input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}