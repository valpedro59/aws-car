$(function () {
    
    $('#contact-form').submit(function(e) {
        e.preventDefault();
        $('.comments').empty();
        let postdata = $('#contact-form').serialize();
        
        $.ajax({
            type: 'POST',
            url: './contact.php',
            data: postdata,
            dataType: 'json',
            success: function(json) {
                 
                if(json.isSuccess) 
                {
                    $('#contact-form').append("<p class='thank-you'>Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>");
                    $('#contact-form')[0].reset();
                }
                else
                {
                    $('#username + .comments').html(json.usernameError);
                    $('#email + .comments').html(json.emailError);
                    $('#phone + .comments').html(json.phoneError);
                    $('#subject + .comments').html(json.subjectError);
                    $('#car + .comments').html(json.carError);
                    $('#content + .comments').html(json.contentError);
                }                
            }
        });
    });

})