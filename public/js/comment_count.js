$(document).ready(function () {
commCount();
    

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

            // Update the comment count display
            $('#comment-count').text(data.count);

        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}