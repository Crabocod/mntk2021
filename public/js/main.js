$(document).ready(function() {
    // $('.select').each(function() {
    //     const _this = $(this),
    //         selectOption = _this.find('option'),
    //         selectOptionLength = selectOption.length,
    //         selectedOption = selectOption.filter(':selected'),
    //         duration = 450; // длительность анимации
    //
    //     let newSelect = _this.find('.new-select');
    //
    //     _this.hide();
    //     _this.wrap('<div class="select select-jopa"></div>');
    //     $('<div>', {
    //         class: 'new-select',
    //         text: _this.children('option:disabled').text()
    //     }).insertAfter(_this);
    //
    //     const selectHead = _this.next('.new-select');
    //     $('<div>', {
    //         class: 'new-select__list'
    //     }).insertAfter(selectHead);
    //
    //     const selectList = selectHead.next('.new-select__list');
    //     for (let i = 1; i < selectOptionLength; i++) {
    //         $('<div>', {
    //             class: 'new-select__item',
    //             html: $('<span>', {
    //                 text: selectOption.eq(i).text()
    //             })
    //         })
    //             .attr('data-value', selectOption.eq(i).val())
    //             .appendTo(selectList);
    //     }
    //
    //     const selectItem = selectList.find('.new-select__item');
    //     selectList.slideUp(0);
    //     selectHead.closest('.select-jopa').on('click', function() {
    //         if (!$(this).hasClass('on')) {
    //             $(this).addClass('on');
    //             selectList.slideDown(duration);
    //
    //             selectItem.on('click', function() {
    //                 let chooseItem = $(this).data('value');
    //
    //                 $(this).val(chooseItem).attr('selected', 'selected');
    //                 selectHead.text($(this).find('span').text());
    //
    //                 selectList.slideUp(duration);
    //                 selectHead.removeClass('on');
    //             });
    //
    //         } else {
    //             $(this).removeClass('on');
    //             selectList.slideUp(duration);
    //         }
    //     });
    // });


    $(".timer").ready(function() {
        if ($(".timer").length === 0)
            return false;
        var date = $(".timer").attr("data-finish");
        // date = new Date(date);
        var t = date.split(/[- :]/);
        var d = new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]);
        date = new Date(d);
        timer(date.getTime());
    });

    function timer(f_time) {
        function timer_go() {
            var n_time = Date.now();
            var diff = f_time - n_time;
            if (diff <= 0) {
                document.location.href = '/acquaintance';
                return false;
            }
            var left = diff % 1000;

            //секунды
            diff = parseInt(diff / 1000);
            var s = diff % 60;
            if (s < 10) {
                $(".seconds_1").html(0);
                $(".seconds_2").html(s);
            } else {
                $(".seconds_1").html(parseInt(s / 10));
                $(".seconds_2").html(s % 10);
            }
            //минуты
            diff = parseInt(diff / 60);
            var m = diff % 60;
            if (m < 10) {
                $(".minutes_1").html(0);
                $(".minutes_2").html(m);
            } else {
                $(".minutes_1").html(parseInt(m / 10));
                $(".minutes_2").html(m % 10);
            }
            //часы
            diff = parseInt(diff / 60);
            var h = diff % 24;
            if (h < 10) {
                $(".hours_1").html(0);
                $(".hours_2").html(h);
            } else {
                $(".hours_1").html(parseInt(h / 10));
                $(".hours_2").html(h % 10);
            }
            //дни
            var d = parseInt(diff / 24);
            if (d < 10) {
                $(".days_1").html(0);
                $(".days_2").html(d);
            } else {
                $(".days_1").html(parseInt(d / 10));
                $(".days_2").html(d % 10);
            }
            setTimeout(timer_go, left);
        }

        setTimeout(timer_go, 0);
    }


    $('.main-nav a').click(function() {
        $('.main-nav a').removeClass('active')
        $(this).addClass('active')
    });

    $('.activty-toggle_menu').click(function() {
        console.log('ff');
        $(this).toggleClass('active')
        $(this).next().slideToggle()
    })

    $('.toggle-menu').click(function() {
        $(this).toggleClass('active')
        $('.header-second').slideToggle()
            // $(this).next().slideToggle()
    })

    $('.grade-block').click(function(e) {
        e.preventDefault();
        $('.grade-block').removeClass('active')
        $(this).addClass('active')
    })

    var margin = 0; // переменная для контроля докрутки
    $(".full-nav a").click(function() { // тут пишите условия, для всех ссылок или для конкретных
        $("html, body").animate({
            scrollTop: $($(this).attr("href")).offset().top + margin + "px" // .top+margin - ставьте минус, если хотите увеличить отступ
        }, {
            duration: 1600, // тут можно контролировать скорость
            easing: "swing"
        });
        return false;
    });
    $('.nav-toggle').click(function() {
        $('.nav-toggle').removeClass('active')
        $('.nav-toggle').not(this).next().slideUp()
        $(this).toggleClass('active')
        $(this).next().slideToggle()
    })
    $('.photo-slides').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.arhive-blocks').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.01,
                    slidesToScroll: 1
                }
            }
        ]
    });
})