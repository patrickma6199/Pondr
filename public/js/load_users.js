$(document).ready(function() {
    loadUsers(); 

    function loadUsers() {
        $.ajax({
            url: '../scripts/load_users.php', 
            type: 'POST',
            success: function(response) {
                $('#user-list').html(response); 
            }
        });
    }
});
