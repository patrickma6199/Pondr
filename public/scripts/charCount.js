$('textarea').keyup(function(){
    var charCount = $(this).val().length;

    curr = $('#curr');
    max = $('#max');
    count = $('#char-count') ;
    current.text(charCount);
})