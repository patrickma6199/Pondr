// For verifying that email and password re-entries are the same
// use jquery

$(document).ready(function(){
    $('#regform').submit(function(e){
        var email = $('#email').val();
        var confirmEmail = $('#re-email').val();
        var password = $('#password').val();
        var confirmPassword = $('#re-password').val();

    if(email !== confirmEmail) {
        alert('The email addresses do not match. Please try again.');
        e.preventDefault();
    } else if(password !== confirmPassword) {
        alert('The passwords do not match. Please try again.');
        e.preventDefault(); 
    }
    });
});