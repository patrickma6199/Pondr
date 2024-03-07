$(document).ready(function(){
    var count = 0 ;

    $("#like-button").on("click",function(e){
        e.preventDefault();
        count += 1;

        $.ajax({
            url: 'scripts/likes.php', // The PHP file that updates the likes in the database
            type: 'POST',
            data: {postId: postId},
            success: function(data){
                // Assuming the PHP script returns the new like count
                $('#like-count-' + postId).text(data);
            }
        });
    });
    
});
