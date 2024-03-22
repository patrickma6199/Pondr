$(document).ready(function() {
    $('#regform, #loginform').on('submit', function(e) {
        e.preventDefault(); // Prevent form from submitting until checks are done

        var firstName = $('#firstName').val().trim();
        var lastName = $('#lastName').val().trim();
        var email = $('#email').val().trim();
        var confirmEmail = $('#re-email').val().trim();
        var username = $('#username').val().trim();
        var password = $('#password').val();
        var confirmPassword = $('#re-password').val();
        
        // Regex for validation
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        var validationFailed = false;

        // Check first name
        if (!firstName) {
            $('#error-firstname').text('Please enter your first name.').show();
            validationFailed = true;
        }

        // Check last name
        if (!lastName) {
            $('#error-lastname').text('Please enter your last name.').show();
            validationFailed = true;
        }

        // Check email
        if (!emailRegex.test(email)) {
            $('#error-email').text('Please enter a valid email address.').show();
            validationFailed = true;
        }

        // Check confirm email
        if (email !== confirmEmail) {
            $('#error-reemail').text('Email addresses do not match.').show();
            validationFailed = true;
        }

        // Check username
        if (!username) {
            $('#error-username').text('Please enter a username.').show();
            validationFailed = true;
        }

        // Check password
        if (!passwordRegex.test(password)) {
            $('#error-password').text('Password must be at least 8 characters long, contain a number, a special character, and a capital letter.').show();
            validationFailed = true;
        }

        // Check confirm password
        if (password !== confirmPassword) {
            $('#error-repassword').text('Passwords do not match.').show();
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
