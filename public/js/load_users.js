$(document).ready(function() {
    loadUsers(); // Load users when the page is ready

    function loadUsers() {
        $.ajax({
            url: '../scripts/load_users.php', // PHP script to return user list
            type: 'POST',
            success: function(response) {
                $('#user-list').html(response); // Populate the user list div
            }
        });
    }
});
