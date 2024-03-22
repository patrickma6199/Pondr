$(document).ready(function () {
    let link = $('input[name="post_link"]')
    let validURL = /^https?:\/\/(?:\w+\.)+\w+$/;
    let valid = /^$/;
    link.on('keyup', (e) => {
        if (!validURL.test(link.val())) {
            console.log("Invalid URL");
        }
    });
});