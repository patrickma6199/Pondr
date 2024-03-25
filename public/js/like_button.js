$(document).ready(function() {

    setInterval(getLikeCount, 5000);
    updateLikeButton();
    getLikeCount();
   
    $('#like-button').click(function(e) {
        e.preventDefault();
        const pid_param = new URLSearchParams(window.location.search);
        var postId = pid_param.get('postId'); 
        const action = 'like'; 

        $.ajax({
            type: 'POST',
            url: '../scripts/likes.php',
            data: {postId: postId, action: action},
            success: function (data) {
                if (data.error !== undefined) {
                    console.log(data.error);
                }
                else {
                    if (data.success) {
                        console.log("liked successfully!");
                        if (data.liked) {
                            $('#like-button').addClass('liked');
                        } else {
                            $('#like-button').removeClass('liked');
                        }
                    }
                    getLikeCount();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log("status:", status);
            }
        });
    });
});
        
function getLikeCount(){
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');   

    let serializedData = `postId=${postId}&action=fetch`;

    $.ajax({
        type: 'POST',
        url: '../scripts/likes.php',
        data: serializedData,
        success: function(data) {
            if (data.error !== undefined) {
                console.log(data.error);
            } else {
                $('#like-count').text(data.likes);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log("status:", status);
        }
    });
}

function updateLikeButton() {
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');

    let serializedData = `postId=${postId}&action=checkLiked`;
    
    $.ajax({
        type: 'POST',
        url: '../scripts/likes.php',
        data: serializedData,
        success: function (data) {
            if (data.error !== undefined) {
                console.log(data.error);
            } else {
                if (data.liked) {
                    $('#like-button').addClass('liked');
                } else {
                    $('#like-button').removeClass('liked');
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            console.log("status:", status);
        }
    });
}
