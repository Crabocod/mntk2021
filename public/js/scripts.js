// Ajax --------------------------------------------------------------------------------------------
function request(object) {
    if (typeof (object.url) !== 'string')
        return false;
    if (typeof (object.method) !== 'string')
        object.method = 'GET';
    if (typeof (object.data) !== 'object')
        object.data = {};

    if(typeof object.required_fields === 'object') {
        let inputErrors = [];
        object.required_fields.each(function() {
            if($(this).val() === undefined)
                inputErrors.push($(this));
            else if($(this).is('input') && $(this).val() === '')
                inputErrors.push($(this));
            else if($(this).is('select') && $(this).val() === 0)
                inputErrors.push($(this));
        });
        if(inputErrors.length > 0) {
            inputError(inputErrors);
            return false;
        }
    }

    var button_text = '';
    var button_width = '';
    if (typeof (object.button) === 'object') {
        button_text = object.button.text();
        button_width = object.button.css('width');
    }

    $.ajax({
        type: object.method,
        url: object.url,
        data: object.data,
        dataType: "json",
        beforeSend: function (jqXHR, textStatus) {
            if (typeof (object.button) === 'object') {
                object.button.css('width', button_width);
                // object.button.css('background', '#808080');
                object.button.attr('disabled', 'disabled');
                object.button.text('Ждите...');
            }
            if (typeof (object.beforeSend) === 'function')
                object.beforeSend(jqXHR, textStatus);
        },
        statusCode: {
            200: function (data) {
                if (data.status === 'ok')
                    object.success(data);
                else if (data.status === 'error')
                    object.error(data);
            },
            403: function () {
                alert("Доступ запрещен! Пожалуйста, обновите страницу.")
            }
        },
        complete: function (jqXHR, textStatus) {
            if (typeof (object.button) === 'object') {
                object.button.css('width', '');
                object.button.css('background', '');
                object.button.removeAttr('disabled');
                object.button.text(button_text);
            }
            if (typeof (object.complete) === 'function')
                object.complete(jqXHR, textStatus);
        }
    });
}

// Masked Phone ------------------------------------------------------------------------------------
function MaskedPhone() {
    var phonemaskOk = 0;

    $(".MaskedPhone").inputmask("7 (999) 999-99-99", {
        "oncomplete": function () {
            phonemaskOk = 1;
        },
        "onincomplete": function () {
            phonemaskOk = 0;
        },
        "oncleared": function () {
            phonemaskOk = 0;
        }
    });
}

// Подстветка элемента формы при ошибке ------------------------------------------------------------
function inputError(item) {
    if (typeof stopInputError === 'undefined')
        window.stopInputError = false;

    // Продолжаем только если inputError() ещё не запущен
    if (stopInputError == false)
        stopInputError = true;
    else
        return false;

    function setError(formElem, hasFocus = true) {
        var bcolor = formElem.css('background-color');

        formElem.css({'background-color': '#fed1dd'});
        if(hasFocus)
            formElem.focus();

        setTimeout(function () {
            formElem.css({'background-color': bcolor});
            stopInputError = false;
        }, 400);
    }
    if(item instanceof jQuery)
        setError(item);
    else if(typeof item == 'object') {
        item = item.reverse();
        for (const itemElement of item) {
            let hasFocus = (itemElement === item[item.length-1]);
            if(itemElement instanceof jQuery)
                setError(itemElement, hasFocus);
        }
    }
}

function ckeditorError(editable) {
    if (typeof stopInputError === 'undefined')
        window.stopInputError = false;

    // Продолжаем только если inputError() ещё не запущен
    if (stopInputError == false)
        stopInputError = true;
    else
        return false;

    var bcolor = editable.css('background-color');

    editable.css({'background-color': '#fed1dd'});

    setTimeout(function () {
        editable.css({'background-color': bcolor});
        editable.focus();
        stopInputError = false;
    }, 500);
}

// Маска для ввода только чисел, точки и пробелов --------------------------------------------------
$(document).ready(function () {
    $('[type=quantity]').bind("input click", function () {
        this.value = this.value.replace(/^([^\.]*\.)|\./g, '$1');
        if (this.value.match(/[^0-9\.\s]/g)) {
            this.value = this.value.replace(/[^0-9\.\s]/g, '');
        }
    });
});

// Открытие модального окна для ошибок -------------------------------------------------------------
function errorModal(message) {
    var modal = $('[data-remodal-id=error]');
    modal.find('p').html(message);
    var inst = modal.remodal();
    inst.open();
    return inst;
}

// Открытие модального окна для уведомлений --------------------------------------------------------
function successModal(message) {
    var modal = $('[data-remodal-id=success]');
    modal.find('p').html(message);
    var inst = modal.remodal();
    inst.open();
    return inst;
}

// Открытие модального окна с подтвеждением --------------------------------------------------------
function confirmModal(message) {
    var modal = $('[data-remodal-id=confirm]');
    modal.find('p').html(message);
    var inst = modal.remodal();
    inst.open();
    return inst;
}

// Событие закрытия модального окна ошибок ---------------------------------------------------------
var closeErrorModal = function () {
};
$(document).on('closed', '[data-remodal-id=error]', function (e) {
    closeErrorModal();
});

// Событие закрытия модального окна уведомлений ----------------------------------------------------
var closeSuccessModal = function () {
};
$(document).on('closed', '[data-remodal-id=success]', function (e) {
    closeSuccessModal();
});

// Подтверждение в модальном окне ------------------------------------------------------------------
var confirmationConfirmModal = function () {
};
$(document).on('confirmation', '[data-remodal-id=confirm]', function (e) {
    confirmationConfirmModal();
});

/**
 * Возвращает функцию, вызывающую исходную с задержкой delay в контексте ctx. Если во время задержки функция
 * была вызвана еще раз, то предыдующий вызов отменяется, а таймер обновляется. Таким образом из нескольких
 * вызовов, совершающихся чаще, чем delay, реально будет вызван только последний.
 *
 * @param {Number} delay
 * @param {Object} [ctx]
 *
 * @return {Function}
 */
(function (Function_prototype) {
    Function_prototype.debounce = function (delay, ctx) {
        var fn = this, timer;
        return function () {
            var args = arguments, that = this;
            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(ctx || that, args);
            }, delay);
        };
    };
})(Function.prototype);

$(document).ready(function () {
    $("body").on("click", ".cmn-toggle-switch__htx", function (event) {
        $('.cmn-toggle-switch__htx').toggleClass('active');
        $('.mobile-menu').toggleClass('active');
        $('.over-menu').toggleClass('active');
    });

    $('input[name="phone"]').each(function () {
        $(this).mask("9(999) 999-9999");
    });

    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : { allow_single_deselect: true },
        '.chosen-select-no-single' : { disable_search_threshold: 10 },
        '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
        '.chosen-select-rtl'       : { rtl: true },
        '.chosen-select-width'     : { width: '95%' }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
});

$(document).ready(function () {
    litepickerRestart();
});

function litepickerRestart() {
    if (($(".litepicker-date").length > 0)) {
        let inputFields = document.querySelectorAll('.litepicker-date');
        for (let input of inputFields) {
            var picker = new Litepicker({
                element: input,
                singleMode: true,
                lang: 'ru-RU',
                format: 'DD.MM.YYYY',
                tooltipText: {
                    one: 'день',
                    few: 'дня',
                    many: 'дней',
                },
                setup: (picker) => {
                    input.addEventListener('change', function(event) {
                        if (!event.target.value)
                            picker.clearSelection();
                    });
                }
            });
        }
    }
}

$(document).ready(function() {
    $('body').on('click', '[type="checkbox"]', function() {
        var $this = $(this);
        $($this).closest('label').toggleClass('active');
    });
});

function setEditor(elem, options) {
    ClassicEditor
        .create(elem, {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'htmlEmbed',
                    'undo',
                    'redo'
                ]
            },
            language: 'ru',
            image: {
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight'
                ],
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ],
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    '|',
                    'resizeImage',
                    '|',
                    'imageTextAlternative'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
            simpleUpload: {
                // The URL that the images are uploaded to.
                uploadUrl: options.url,

                // Enable the XMLHttpRequest.withCredentials property.
                withCredentials: true,

                // Headers sent along with the XMLHttpRequest to the upload server.
                headers: {
                    'X-CSRF-TOKEN': 'CSRF-Token',
                    Authorization: 'Bearer <JSON Web Token>'
                }
            },
        })
        .then(editor => {
            if(typeof options.getInstance == 'function')
                options.getInstance(editor);
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: ri7v1p70871p-nohdljl880ze');
            console.error(error);
        });
}

function getUrlSegments(url = '') {
    if(url == '')
        url = document.location.pathname;
    if(url[0] == '/')
        url = url.slice(1);
    return url.split('/');
}

Date.prototype.format = function (mask, utc) {
    return dateFormat(this, mask, utc);
};

$('#jquery_jplayer_1').ready(function() {
    var mp3_src = $('#jquery_jplayer_1').attr('mp3_src');

    // $('#jquery_jplayer_1').jPlayer({
    //     ready: function (event) {
    //         ready = true;
    //         $(this).jPlayer("setMedia", {
    //             mp3: mp3_src,
    //             // oga: "http://jplayer.org/audio/ogg/Miaow-07-Bubble.ogg"
    //         });
    //     },
    //     pause: function() {
    //         $(this).jPlayer("clearMedia");
    //     },
    //     error: function(event) {
    //         if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
    //             $(this).jPlayer("setMedia", {
    //                 mp3: mp3_src
    //             }).jPlayer("play");
    //         }
    //     },
    //     swfPath: "../../dist/jplayer",
    //     supplied: "m4a, oga, mp3",
    //     wmode: "window",
    //     useStateClassSkin: true,
    //     autoBlur: false,
    //     smoothPlayBar: true,
    //     remainingDuration: true,
    //     toggleDuration: true,
    //     keyEnabled: true,
    //     preload: 'none',
    // });


    var stream = {
        title: "Audio",
        mp3: mp3_src
    },
    ready = false;

    $("#jquery_jplayer_1").jPlayer({
        ready: function (event) {
            ready = true;
            $(this).jPlayer("setMedia", stream);
        },
        pause: function() {
            $(this).jPlayer("clearMedia");
        },
        error: function(event) {
            if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
                // Setup the media stream again and play it.
                $(this).jPlayer("setMedia", stream).jPlayer("play");
            }
        },
        stalled: function(event) {
            $scope.ObjID.jPlayer("playHead",$scope.currentPlayerPosition);
            $scope.disableEnablePlay('simple','enable');
        },
        suspend: function(event) {
            $scope.ObjID.jPlayer("playHead",$scope.currentPlayerPosition);
            $scope.disableEnablePlay('simple','enable');
        },
        swfPath: "../dist/jplayer",
        supplied: "mp3",
        preload: "none",
        wmode: "window",
        useStateClassSkin: true,
        autoBlur: false,
        keyEnabled: true
    });
});
