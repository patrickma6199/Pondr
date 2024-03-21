$(document).ready(function(e){
   
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');

    $('#add-comment').click(function(e){
        e.preventDefault();
       var textarea = ('<br><br><textarea class="thread-comment-container" id="comment-text"></textarea><button id="submit-comment">Submit</button>');
       $(this).after(textarea);
       


        $('#submit-comment').click(function(){
            var commentText = $('#comment-text').val(); 
            location.reload(true);

            $.ajax({
                type: "POST",
                url: "../scripts/add_comment.php", // Your PHP script to handle the insert
                data: { postId: postId, commentText: commentText },
                success: function(data){
                    console.log("result  :", data);
                    console.log("Comment submitted successfully!");
                   

                   
                },
                error: function (xhr, status, error) {
            console.error('Error:', error);
        }
        })
        $('#comment-text').replaceWith('');
        $('#submit-comment').replaceWith('');
       
    })
  



});
});
