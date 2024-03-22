$(document).ready(function () {
    let link = $('input[name="post_link"]')
    let validURL = /^https?:\/\/(?:\w+\.)+\w+$/;
    let error_mes = $("#error-postLink");
    let valid = /^$/;
    link.on('keyup', function() {
        if (!validURL.test(link.val())) {
            error_mes.html("URL is invalid. Please follow this format: https://AAAAAA.AAA/AAA/AAA/").show();
        } else {
            error_mes.hide();
        }
    });
});