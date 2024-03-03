$(document).ready(function(){
    var maxLen = 3000;
    $('#max').text('/ ' + maxLen) ;

    $('textarea[name="post_text"]').keyup(function(){
        var curLen = $(this).val().length ;
        
        $('#curr').text(curLen) ;

       
    });

});