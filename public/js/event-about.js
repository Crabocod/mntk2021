$(document).ready(function () {
    $(document).on('click', '.ajax-event-sign:not("[disabled]")', function (e) {
        e.preventDefault();
        var data = {};
        data['event_id'] = $('.event-id')[0].value;
        var button_text = $(this).text();
        request({
            url: document.location.pathname + '/sign-up',
            method: 'get',
            data: data,
            beforeSend: function () {
                $('.ajax-event-sign').attr('disabled', 'disabled');
                $('.ajax-event-sign').text('Ждите...');
            },
            success: function (data) {
                $('.ajax-event-sign').addClass('sign1').attr('disabled', 'disabled');
            },
            error: function (data) {
                errorModal(data.message);
            },
            complete: function () {
                $('.ajax-event-sign').text(button_text);
            }
        });
    });
})