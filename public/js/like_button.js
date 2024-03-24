$(document).ready(function() {

    setInterval(getLikeCount,5000);
    
    getLikeCount();
    if (localStorage.getItem('postLiked') === 'true') {
        $('#like-button').addClass('liked');
    } else {
        $('#like-button').removeClass('liked');
    }
   
    
    $('#like-button').click(function(e) {
        e.preventDefault();
        const pid_param = new URLSearchParams(window.location.search);
        var postId = pid_param.get('postId'); 
        const action = $(this).hasClass('liked') ? 'unlike' : 'like'; 

        $.ajax({
            type: 'POST',
            url: '../scripts/likes.php',
            data: { postId: postId, action: action },
            success: function(data) {
                console.log("likes: ",data);
                updateLikeButton(data);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
});
        



async function getLikeCount(){
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');   

    let serializedData = `postId=${postId}&action=fetch`;

    $.ajax({
        type: 'POST',
        url: '../scripts/likes.php',
        data: serializedData,
        success: function(data) {
            
            
            console.log("result :",data.error);
            
            
                $('#like-count').text(data.likes);
         
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log("status:",status)
        }
    });


}

function updateLikeButton(data) {
    if (data.liked === false) {
        $('#like-button').removeClass('liked');
        localStorage.setItem('postLiked', 'false');
    } else {
        $('#like-button').addClass('liked');
        localStorage.setItem('postLiked', 'true');
    }
    $('#like-count').text(data.likes);
}
