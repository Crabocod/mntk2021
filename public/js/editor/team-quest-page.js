$(document).ready(function(){
    $('#jq-add input').on('keypress', function(e){
        var code = e.keyCode || e.which;
        if( code === 13 ) {
            e.preventDefault();
            $( ".ajax-add" ).click();
        }
    });

    $('body').on('keypress', '.jq-save input', function(e){
        var code = e.keyCode || e.which;
        if( code === 13 ) {
            e.preventDefault();
            $(this).closest('.body-grid').find( ".ajax-update" ).click();
        }
    });
});

$(document).ready(function(){
    $(document).on('click', '.ajax-update', function (e) {
        e.preventDefault();
        var btn = $(this);

        if($(this).closest('.body-grid').find('.ajax-title input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-title input'));
        if($(this).closest('.body-grid').find('.ajax-points input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-points input'));

        var data = {};
        data['id'] = $(this).closest('.btns-control').find('.result_id').val();
        data['title'] = $(this).closest('.body-grid').find('.ajax-title input')[0].value
        data['points'] = $(this).closest('.body-grid').find('.ajax-points input')[0].value;


        request({
            url: document.location.pathname+'/update',
            method: 'post',
            data: data,
            success: function (data) {
                successModal(data.message);
            },
            error: function (data) {
                errorModal(data.message);
            },
            button: btn
        });
    });

    $(document).on('click', '.ajax-delete', function (e) {
        e.preventDefault();
        confirmModal();
        var data = {};
        data['id'] = $(this).closest('.btns-control').find('.result_id')[0].value;
        var el = $(this).closest('.body-grid');
        confirmationConfirmModal = function (){
            request({
                url: document.location.pathname+'/delete',
                method: 'post',
                data: data,
                success: function (data) {
                    el.remove();
                },
                error: function (data) {
                    errorModal(data.message);
                },
            });
        };
    });

    $(document).on('click', '.ajax-add', function (e) {
        e.preventDefault();
        var btn = $(this);
        if($(this).closest('.body-grid').find('.ajax-title input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-title input'));
        if($(this).closest('.body-grid').find('.ajax-points input')[0].value == '')
            return inputError($(this).closest('.body-grid').find('.ajax-points input'));

        var data = {};
        data['title'] = $(this).closest('.body-grid').find('.ajax-title input')[0].value;
        data['points'] = $(this).closest('.body-grid').find('.ajax-points input')[0].value;

        request({
            url: document.location.pathname+'/update',
            method: 'post',
            data: data,
            success: function (data) {
                $('.ajax-add').closest('.body-grid').find('.ajax-title input')[0].value = '';
                $('.ajax-add').closest('.body-grid').find('.ajax-points input')[0].value = '';

                $("#jq-add").before(data.html);
            },
            error: function (data) {
                errorModal(data.message);
            },
            button: btn
        });
    });
})