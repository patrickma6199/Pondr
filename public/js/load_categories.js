$(document).ready(function () { 
    load_categories();
    setInterval(load_categories, 5000);
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
                        let p1 = $('<p>');
                        let p2 = $('<p>');
                    
                        let href = "./discussion.php?catName=" + category.catName;
                        if (search) {
                            href += "&search=" + encodeURIComponent(search);
                        }
                        p1.text(category.catName);
                        p1.css("font-weight", "bold");
                        p1.css("font-size", "1.1em");
                        p1.css("margin-bottom", "0");
                        p1.css("padding-bottom","0");
                        p2.text(`Posts made: ${category.catCount}`);
                        p2.css("font-size", "0.7em");
                        p2.css("margin-top", "0");
                        p2.css("padding-top","0");
                        a.attr('href', href);
                        a.append(p1);
                        a.append(p2);
                        li.append(a);
                        cat_list.append(li);
                    });
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Category Error:', error);
            console.log("status:", status);
        }
    });
}