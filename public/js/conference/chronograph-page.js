$(document).ready(function (){
   $(document).on('click', '.send-answer-js', function (e){
       e.preventDefault();

       let data = {}
       data.answer = $(this).closest('.qustion-block').find('textarea[name=answer]').val();
       data.id = $(this).closest('.qustion-block').find('input[name=id]').val();
       let btn = $(this);

       request({
           url: document.location.pathname+'/add-answer',
           method: 'post',
           data: data,
           success: function(data) {
               successModal(data.message);
           },
           error: function(data) {
               errorModal(data.message);
           },
           button: btn
       });
   });
});