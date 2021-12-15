$('textarea#znakomstvo_text').ready(function() {
    var urlSegments = getUrlSegments(document.location.pathname);

    setEditor(document.getElementById('znakomstvo_text'), {
        url: '/admin/save-ckeditor-image',
    });
});

$(document).ready(function (){
    $('.znakomstvo-update').on('submit', function (e){
        e.preventDefault();
        let form = $(this);
        request({
            url: document.location.pathname + '/update',
            method: 'post',
            data: form.serializeArray(),
            success: function (data) {
                successModal(data.message);
            },
            error: function (data) {
                errorModal(data.message);
            },
        });
    });
});