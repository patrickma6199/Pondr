$(document).ready(function() {

    setInterval(getLikeCount(),1000);
    
     getLikeCount();

    
    $('#like-button').click(function(e) {
        increaseLikeCount(e);
        
    });
    
   
    
});

function increaseLikeCount(e) {

    e.preventDefault(); // Prevent the default action
    
    
    const pid_param = new URLSearchParams(window.location.search);
    var postId = pid_param.get('postId');  


    $.ajax({
        type: 'POST',
        url: '../scripts/likes.php',
        data: { postId: postId },
        success: function(data) {
            console.log("postId",postId);
           
            
            console.log("result :",data.error);
            
                $('#like-count').text(data.likes);
         
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

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
