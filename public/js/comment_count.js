$(document).ready(function () {
   
    commCount();
    var comm_update = setTimeout(commCount() ,1000);
    comm_update;

   
});
async function commCount(){
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');

    $.ajax({
        type: 'POST',
        url: '../scripts/comments.php',
        data: { postId: postId },
        success: function (data) {

            console.log("result comm :", data);
           if(data == "done"){window.location.href="thread_user.php"}
            // Update the comment count display
            $('#comment-count').text(data.count);
           
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
