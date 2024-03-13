$(document).ready(function(){
    var postId = 2;
    $.ajax({
    type: 'POST',
    url: '../scripts/comment_count.php',
    data: { postId: postId },
    success: function(data) {
    var result = JSON.parse(data);
    console.log("result :",result);
    
    // Update the comment count display
    $('#comment-count').text(result);
    
    },
    error: function(xhr, status, error) {
    console.error('Error:', error);
    }
    });
    
    });