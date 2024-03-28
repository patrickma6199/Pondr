$(document).ready(function(){
    var maxLen = 3000;
    $('#max').text('/ ' + maxLen);
    let curLen = $('textarea[name="post_text"]').val().length;

    $('textarea[name="post_text"]').keyup(function() {
        curLen = $(this).val().length;
        if (curLen > maxLen) {
            $('#char-count').css("color", "red");
        } else {
            $('#char-count').css("color", "lightgray");
        }

        $('#curr').text(curLen);
    });

    $("form").on('submit', (e) => { 
        if (curLen > maxLen) {
            e.preventDefault();
           
            alert("Post text cannot have more than 3000 characters.");
        }
    });
});