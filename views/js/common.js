$(document).ready(function(){
    $('body').on('click', '.login_active', function(event){
        event.preventDefault();
        if($(this).hasClass('active'))
        {
            $(this).removeClass('active')
            $('.login-form').slideUp();
        }
        else
        {
            $(this).addClass('active')
            $('.login-form').slideDown();
        }

    });
});