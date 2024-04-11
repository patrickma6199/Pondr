$(document).ready(function () {
    let category_timeout;
    $("#cat-search").on('input focus', function () {
        clearTimeout(category_timeout);
        let catName = $(this).val().trim();
        checkCategories(catName);
    });
    $('#cat-search').on('focusout', function () {
        category_timeout = setTimeout(clearCategories,200); // set timeout so that users can still click results
    });
});

function clearCategories() {
    $('#category-results').empty();
}

function checkCategories(catName) { 
        $.ajax({
            type: 'POST',
            url: '../scripts/search_category.php',
            data: { catName: catName },
            success: function (data) {
                if (data.error !== undefined) {
                    console.error(data.error);
                } else {
                    // Update the comment count display
                    let cat_results = $('#category-results').empty();
                    data.catNames.forEach(function (name) {
                        let a = $('<p>').text(name).on('click', function (e) {
                            $('#cat-search').val(name);
                        });
                        cat_results.append(a);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
}