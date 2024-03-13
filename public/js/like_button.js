function increaseLikeCount(e) {

    e.preventDefault(); // Prevent the default anchor action
    console.log("RUNNING LIKE FUNCTION WIT", e)
    // Assuming you have an identifier for the content. Here, we use a placeholder.
    var postId = 2;

    $.ajax({
        type: 'POST',
        url: '../scripts/likes.php',
        data: { postId: postId },
        success: function(data) {
            var result = JSON.parse(data);
            console.log("result :",result);
            // if(result.success) {
                // Update the like count display
                $('#like-count').text(result);
            // }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

$(document).ready(function(){
    
    $.ajax({
        url: 'thread_user.php',
        type: 'get',
        dataType: 'JSON',
        success: function(data){
        var result = JSON.parse(data);
        alert(JSON.stringify(data));
        if(result.success){
            
        }
          

        }
    });
});
