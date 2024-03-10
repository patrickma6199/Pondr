function increaseLikeCount(e) {
    e.preventDefault(); // Prevent the default anchor action

    // Assuming you have an identifier for the content. Here, we use a placeholder.
    var postId = 'YOUR_CONTENT_ID';

    $.ajax({
        type: 'POST',
        url: 'likes.php',
        data: { postId: postId },
        success: function(data) {
            var result = JSON.parse(data);
            if(result.success) {
                // Update the like count display
                $('#like-count').text(result.newCount);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}
