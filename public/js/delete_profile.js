$(document).ready(function() {

    $('#delete-profile-button').click(function (e) {
        e.preventDefault();
        const pid_param = new URLSearchParams(window.location.search);
        var uName = pid_param.get('uName');
        console.log(uName);


        $.ajax({
            type: 'POST',
            url: '../scripts/delete_profile.php',
            data: { uName: uName },
            success: function (data) {
                console.log("delete: ", data);

            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });

    });


});