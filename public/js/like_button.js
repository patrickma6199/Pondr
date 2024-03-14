function increaseLikeCount(e) {

    e.preventDefault(); // Prevent the default action
    
    const pid_param = new URLSearchParams(window.location.search);
    pid_param.has('postId') ;
    var postId = 
    // pid_param.get('postId') ;    


    $.ajax({
        type: 'POST',
        url: '../scripts/likes.php',
        data: { postId: postId },
        success: function(data) {
            var result = JSON.parse(data);
            console.log("result :",result);
            
                $('#like-count').text(result);
         
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


