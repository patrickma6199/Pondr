$(document).ready(function () { 
    load_categories();
    setInterval(load_categories, 5000);
    setInterval(load_new_notification, 5000);
});

function load_categories() { 
    const get_params = new URLSearchParams(window.location.search);
    let search = get_params.get('search');
    let cat_list = $("#cat-list");
    $.ajax({
        type: 'POST',
        url: '../scripts/load_categories.php',
        success: function (data) {
            cat_list.empty();
            if (data.error !== undefined) {
                console.error(data.error);
                cat_list.append($('<p>').text(data.error));
                
            } else {
                if (data.categories.length == 0) {
                    cat_list.append($('<p>').text("No Categories have been made yet! Try making one now!"));
                } else {
                    data.categories.forEach(function (category) {
                        let li = $('<li>');
                        let a = $('<a>');
                    
                        let href = "./discussion.php?catId=" + category.catId;
                        if (search) {
                            href += "&search=" + encodeURIComponent(search);
                        }
                        a.attr('href', href);
                        a.text(category.catName);
                        li.append(a);
                        cat_list.append(li);
                    });
                    let li = $('<li>');
                    let a = $('<a>');
                    let href = "./discussion.php";
                    if (search) {
                        href += "?search=" + encodeURIComponent(search);
                    }
                    a.attr('href', href);
                    a.text("Clear Category");
                    li.append(a);
                    cat_list.append(li);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log("status:",status)
        }
    });
}

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
                    
                    setTimeout(function () {
                        message.fadeOut();
                    }, 5000);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.log("status:",status)
        }
    });
}