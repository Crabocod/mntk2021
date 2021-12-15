$(document).ready(function() {
    $('#js-sort-blocks').sortable({
        group: {
            name: 'shared',
            pull: true,
        },
        cancel: '.cancel-cursor-grab',
        handle: '.handle',
        axis: "y",
        animation: 150,
        onUpdate: function () {
            sortModules();
        }
    });

    $('#js-sort-nav-items').sortable({
        group: {
            name: 'shared2',
            pull: true,
        },
        cancel: '.cancel-cursor-grab',
        handle: '.handle',
        onDragStart: function ($item, container, _super) {
            // Duplicate items of the no drop area
            if(!container.options.drop)
                $item.clone().insertAfter($item);
            _super($item, container);
        },
        axis: "y",
        animation: 150,
        onUpdate: function () {
            sortNavItems();
        }
    });

    $(document).on('click', '.js-toggle-visible', function(e) {
        e.preventDefault();
        toggleVisible($(this));
    });

    $(document).on('change', 'form#main-block input[type=file]', function(e) {
        updateMainBlock($(this));
    });

    $(document).on('input', 'form#main-block input[type=text]', function(e) {
        updateMainBlock($(this));
    }.debounce(500));

    $(document).on('input', 'form#main-block input[type=number]', function(e) {
        updateMainBlock($(this));
    }.debounce(500));

    $(document).on('change', 'form#timer', function(e) {
        updateTimer();
    });

    $('body').on('submit', '#add-chess', function (e) {
        e.preventDefault();
        addChess($(this).closest('form'));
    });

    $('body').on('click', '#add-chess .add-icon-row .icon__delete', function (e) {
        e.preventDefault();
        $(this).attr('src', '/img/skrepka.svg');
        $(this).parent().siblings('input').val('');
        $(this).parent().siblings('.icon').find('img').attr('src', '/img/shahmatka.svg');
    });

    $('body').on('change', '#add-chess .add-icon-row input', function (e) {
        e.preventDefault();
        $(this).siblings('.crhrono-label').find('img.icon__delete').attr('src', '/img/delete-krest.svg');
        readLocalImage(this, $(this).siblings('.icon').find('img'));
    });

    $('body').on('click', '.chess-row .btn-cancel', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        confirmModal();
        confirmationConfirmModal = function () {
            deleteChess(form);
        };
    });

    $('body').on('click', '.chess-row .btn-save', function (e) {
        e.preventDefault();
        updateChess($(this).closest('form'));
    });

    $('body').on('click', '.chess-row .icon__delete', function (e) {
        e.preventDefault();
        $(this).attr('src', '/img/skrepka.svg');
        $(this).parent().siblings('input[type=file]').val('');
        $(this).parent().siblings('input[name=deleted_icon]').val('1');
        $(this).parent().siblings('.icon').find('img').attr('src', '/img/shahmatka.svg');
    });

    $('body').on('change', '.chess-row .add-icon-row input[type=file]', function (e) {
        e.preventDefault();
        $(this).siblings('.crhrono-label').find('img.icon__delete').attr('src', '/img/delete-krest.svg');
        readLocalImage(this, $(this).siblings('.icon').find('img'));
    });
});

function sortModules() {
    var sort_numbers = [];
    var i = 1;
    $('#js-sort-blocks [data-block_id]').each(function () {
        sort_numbers.push({
            'id': $(this).attr('data-block_id'),
            'number': i
        });
        i++;
    });

    request({
        url: document.location.pathname+'/sort-blocks',
        method: 'post',
        data: {sort_numbers: JSON.stringify(sort_numbers)},
        success: function (data) {
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function sortNavItems() {
    var sort_numbers = [];
    var i = 1;
    $('#js-sort-nav-items [data-item_id]').each(function () {
        sort_numbers.push({
            'id': $(this).attr('data-item_id'),
            'number': i
        });
        i++;
    });

    request({
        url: document.location.pathname+'/sort-nav-items',
        method: 'post',
        data: {sort_numbers: JSON.stringify(sort_numbers)},
        success: function (data) {
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function toggleVisible(element) {
    let data = {}
    if(element.find('img').attr('src') === '/img/hide.svg')
        data.hide = 0;
    else
        data.hide = 1;
    data.id = element.closest('[data-block_id]').attr('data-block_id');

    request({
        url: document.location.pathname+'/hide-block',
        method: 'post',
        data: data,
        success: function (data) {
            if(element.find('img').attr('src') === '/img/hide.svg')
                element.find('img').attr('src', '/img/visible.svg')
            else
                element.find('img').attr('src', '/img/hide.svg')
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function updateMainBlock() {
    let form = $('#main-block');
    var formData = new FormData();

    let files = form.find('input[name=logo]').get(0).files;

    if(files.length > 0)
        formData.append('logo', files[0], files[0].name);
    formData.append('title', form.find('[name=title]').val());
    formData.append('sub_title', form.find('[name=sub_title]').val());
    formData.append('date', form.find('[name=date]').val());
    formData.append('specialist_num', form.find('[name=specialist_num]').val());
    formData.append('og_num', form.find('[name=og_num]').val());
    formData.append('experts_num', form.find('[name=experts_num]').val());
    formData.append('sections_num', form.find('[name=sections_num]').val());
    formData.append('projects_num', form.find('[name=projects_num]').val());

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/update-main-block',
        data: formData,
        processData: false,
        contentType: false,
        statusCode: {
            200: function(data) {
                if (data.status === 'ok') {

                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function() {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        }
    });
}

function updateTimer() {
    let form = $('form#timer');

    let date = form.find('[name=timer_date]').val();
    let time = form.find('[name=timer_time]').val();

    if(date === undefined || date === '')
        return false;
    if(time === undefined || time === '')
        return false;

    let data = {
        'timer': date+' '+time
    }

    request({
        url: document.location.pathname+'/update-timer',
        method: 'post',
        data: data,
        success: function (data) {
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}

function addChess(form) {
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

    if(moment(form.find('input[name=date]').val(), 'DD.MM.YYYY').isValid() === false)
        return inputError(form.find('input[name=date]'));

    var formData = new FormData(form.get(0));
    var buttonText = form.find('.btn-save').text();

    var date = formData.get('date');
    date = new Date(date.replace(/(\d{2})\.(\d{2})\.(\d{4})/, '$3-$2-$1'));
    var dateTime = date.format('yyyy-mm-dd')+' '+formData.get('time')+':00';
    formData.set('date', dateTime);

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-chess',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.btn-save').text('Ждите...');
            form.find('.btn-save').attr('disabled', 'disabled');
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok') {
                    form.before(data.html);
                    form.find('input').val('');
                    form.find('.add-icon-row img').css('display', 'none');
                    form.find('.add-icon-row span').css('display', 'inherit');
                    litepickerRestart();
                } else if (data.status === 'error') {
                    errorModal(data.message);
                }
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            form.find('.btn-save').text(buttonText);
            form.find('.btn-save').removeAttr('disabled');
        }
    });
}

function updateChess(form) {
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

    var formData = new FormData(form.get(0));
    var buttonText = form.find('.btn-save').text();

    var date = formData.get('date');
    date = new Date(date.replace(/(\d{2})\.(\d{2})\.(\d{4})/, '$3-$2-$1'));
    var dateTime = date.format('yyyy-mm-dd')+' '+formData.get('time')+':00';
    formData.set('date', dateTime);

    $.ajax({
        type: 'post',
        url: document.location.pathname + '/save-chess',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (jqXHR, textStatus) {
            form.find('.btn-save').text('Ждите...');
            form.find('.btn-save').attr('disabled', 'disabled');
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
            form.find('.btn-save').text(buttonText);
            form.find('.btn-save').removeAttr('disabled');
        }
    });
}

function deleteChess(form) {
    var data = {'id' : form.find('input[name=id]').val()}

    request({
        url: document.location.pathname+'/delete-chess',
        method: 'post',
        data: data,
        success: function (data) {
            form.remove();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: form.find('.btn-cancel')
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