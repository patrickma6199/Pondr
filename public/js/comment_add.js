$(document).ready(function(){
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');

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
                if (data.error !== undefined) {
                    console.error(data.error);
                } else {
                    console.log(data.success);
                    location.reload(true);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });

    $(document).on('click', '.reply-icon', function(e){
        e.preventDefault();
        var parentComId = $(this).data('commentid');
        var userName = $(this).data('username');
        console.log();
        var replyTextarea = '<br> <br> <div style="display:flex;"><textarea class="thread-comment-box" id="reply-text-'+ parentComId +'" style="flex-grow: 2;">' + ((userName != undefined) ? `@${userName} ` : '') + '</textarea><button class="submit-reply" data-parentid="'+ parentComId +'" style="cursor: pointer; flex-grow:1;">Submit</button></div>';

        if ($('#reply-text-'+ parentComId).length === 0) {
            $(this).parent().parent().append(replyTextarea);
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
                if (data.error !== undefined) {
                    console.error(data.error);
                } else {
                    location.reload(true);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
