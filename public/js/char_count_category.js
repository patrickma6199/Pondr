$(document).ready(function(){
    var maxLen = 255; 
    $('#max').text('/ ' + maxLen); 
    let curLen = $('#categoryDescription').val().length; 

    $('#categoryDescription').keyup(function() { 
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
            alert("Your description cannot have more than " + maxLen + " characters. Try again!"); 
        }
    });
});
