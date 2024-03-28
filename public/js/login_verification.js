$(document).ready(function() {
    $('#loginform').on('submit', function(e) {
        e.preventDefault(); 

        var validationFailed = false;
        var username = $('#username').val().trim();
        var password = $('#password').val();
       

        // Check username
        if (!username) {
            $('#error-username').text('Please enter a username.').show();
            validationFailed = true;
        }

        // Check password
        if (!password) {
            $('#error-password').text('Please enter a password.').show();
            validationFailed = true;
        }

       
        if (!validationFailed) {
            this.submit();
        }
    });

    
    $('input').on('input', function() {
        $(this).next('.error-message').hide();
    });
});