$(document).ready(function(){
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');

    $('#add-comment').off().on('click', function(e){
        e.preventDefault();
        if ($('#comment-text').length === 0) {
            var textarea = '<br><br><textarea class="thread-comment-box" id="comment-text"></textarea><button id="submit-comment">Submit</button>';
            $(this).after(textarea);
        } else {
            $('#comment-text').focus();
        }
    });

    $(document).on('click', '#submit-comment', function(e){
        var commentText = $('#comment-text').val().trim(); 
        if (commentText === '') {
            alert("Please enter a comment before submitting.");
            $('#comment-text').focus();
            return; 
        }
        
        $.ajax({
            type: "POST",
            url: "../scripts/add_comment.php",
            data: { postId: postId, commentText: commentText },
            success: function(data){
                console.log("Comment submitted successfully!");
                
                location.reload(true);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $(document).on('click', '.reply-icon', function(e){
        e.preventDefault();
        var parentComId = $(this).data('commentid');
        var replyTextarea = '<br> <br> <textarea class="thread-comment-box" id="reply-text-'+ parentComId +'"></textarea><button class="submit-reply" data-parentid="'+ parentComId +'">Submit</button>';

        if ($('#reply-text-'+ parentComId).length === 0) {
            $(this).parent().append(replyTextarea);
        } else {
            $('#reply-text-'+ parentComId).focus();
        }
    });

    $(document).on('click', '.submit-reply', function(e){
        var parentComId = $(this).data('parentid');
        var replyText = $('#reply-text-'+ parentComId).val().trim();
        if (replyText === '') {
            alert("Please enter a reply.");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "../scripts/add_comment.php", 
            data: { postId: postId, parentComId: parentComId, commentText: replyText },
            success: function(data){
                console.log("Reply submitted successfully!");
                
                location.reload(true);
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
