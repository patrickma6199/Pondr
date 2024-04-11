$(document).ready(function () { 
    setInterval(load_new_notification, 5000);
});

function load_new_notification() {
    const get_params = new URLSearchParams(window.location.search);
    let search = get_params.get('search');
    let catId = get_params.get('catId');

    if (!search) {
        search = "";
    }
    if (!catId) {
        catId = "";
    }

    serializedData = `search=${search}&catId=${catId}&lastPost=${lastPostId}`;
    let message = $("#new-post");
    $.ajax({
        type: 'POST',
        url: '../scripts/new_post_notif.php',
        data: serializedData,
        success: function (data) {
            if (data.error !== undefined) {
                console.error(data.error);
            } else {
                if (data.new) {
                    message.text(data.message).show();
                    lastPostId = data.newPID;
                    setTimeout(function () {
                        message.fadeOut();
                    }, 5000);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('New Post Error:', error);
            console.log("status:", status);
            console.log("Result:" + xhr.responseText);
        }
    });
}