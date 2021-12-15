$(document).ready(function(e) {
    $('body').on('submit', 'form#add-group', function(e) {
        e.preventDefault();
        addGroup($(this));
    });

    $('body').on('submit', 'form.update-group', function(e) {
        e.preventDefault();
        updateGroup($(this));
    });

    $('body').on('click', 'form.update-group .btn-cancel', function(e) {
        e.preventDefault();
        confirmModal();
        var button = $(this);
        confirmationConfirmModal = function () {
            deleteGroup(button);
        };
    });

    $('body').on('click', '.btn-distribute-users', function(e) {
        e.preventDefault();
        distributeByGroups($(this));
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
});

function addGroup(form) {
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

    var button = form.find('button.btn-save');

    request({
        url: document.location.pathname+'/add-group',
        method: 'post',
        data: form.serializeArray(),
        success: function (data) {
            form.before(data.html);
            form.find('input[name=title]').val('');
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}

function updateGroup(form) {
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

    var button = form.find('button.btn-save');

    request({
        url: document.location.pathname+'/update-group',
        method: 'post',
        data: form.serializeArray(),
        success: function (data) {
            successModal(data.message);
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}

function deleteGroup(button) {
    var form = button.closest('form');

    request({
        url: document.location.pathname+'/delete-group',
        method: 'post',
        data: form.serializeArray(),
        success: function (data) {
            form.remove();
            getMembersRows();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}

function distributeByGroups(button) {
    request({
        url: document.location.pathname+'/distribute',
        method: 'post',
        data: {},
        success: function (data) {
            successModal(data.message);
            getMembersRows();
        },
        error: function (data) {
            errorModal(data.message);
        },
        button: button
    });
}

function getMembersRows() {
    request({
        url: document.location.pathname+'/get-members-rows',
        method: 'get',
        data: {},
        success: function (data) {
            $('table#members').find('tbody').html(data.html);
        },
        error: function (data) {
            errorModal(data.message);
        }
    });
}