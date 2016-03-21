/**
 * Created by Nikita on 13.03.2016.
 */
$(document).ready(function(){
    $('.subscribe').click(function(e){
        e.preventDefault();
        $(this).parents('.input-group').removeClass('has-error');
        var $email = $(this).parents('form').find('[name="email"]');
        var email = $email.val();
        if(!checkEmail(email)){
            $(this).parents('.input-group').addClass('has-error');
            errorNoty('Email должен быть вида email@example.com');
            return;
        }
        $.post('subscribe/', {source: 'main', gender: $(this).data('gender'), email: email}, function(data){
            if(!checkData(data)) return false;
            data = data.data;
            if(!data.result){
                errorNoty(data.message);
            } else {
                successNoty(data.message);
                $email.val('');
            }
        }).fail(function(){
            errorNoty('Error. Try again later');
        });
    });
});