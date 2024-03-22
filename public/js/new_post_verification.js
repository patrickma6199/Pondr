$(document).ready(function () {
    let link = $('input[name="post_link"]')
    let validURL = /^https?:\/\/(?:\w+\.)+\w+$/;
    let error_mes = $("#error-postLink");
    let form = $('#post-form');
    let valid = /^$/;
    link.on('focusout', function() {
        if (!validURL.test(link.val())) {
            error_mes.text("URL is invalid. Please follow this format: https://AAAAAA.AAA/AAA/AAA/").show();
        } else {
            error_mes.hide();
        }
    });

    form.on('submit', (e) => {
        if (!validURL.test(link.val())) {
            e.preventDefault();
            error_mes.text("URL is invalid. Please follow this format: https://AAAAAA.AAA/AAA/AAA/").show();
        } else {
            error_mes.hide();
        }
    });
});