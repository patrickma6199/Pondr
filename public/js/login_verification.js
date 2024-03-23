$(document).ready(function() {
    $('#loginform').on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting until checks are done

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

        // If no validation has failed, submit the form
        if (!validationFailed) {
            this.submit();
        }
    });

    // Clear the error message when the input is corrected
    $('input').on('input', function() {
        $(this).next('.error-message').hide();
    });
});