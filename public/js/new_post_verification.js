$(document).ready(function () {
    let link = $('input[name="post_link"]')
    const validURL = /^https?:\/\/(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}(?:\/[^\/\s]*)*/;
    let error_mes = $("#error-postLink");
    let form = $('#post-form');
    let valid = /^$/;
    link.on('focusout', function() {
        if (!validURL.test(link.val()) && link.val().length != 0) {
            error_mes.text("URL is invalid. Please follow this format: https://AAAAAA.AAA/AAA/AAA/").show();
        } else {
            error_mes.hide();
        }
    });

    form.on('submit', (e) => {
        if (!validURL.test(link.val()) && link.val().length != 0) {
            e.preventDefault();
            error_mes.text("URL is invalid. Please follow this format: https://AAAAAA.AAA/AAA/AAA/").show();
        } else {
            error_mes.hide();
        }
    });
});