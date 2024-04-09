$(document).ready(function () { 
    load_comments();
    setInterval(check_comments, 5000); // update the comments every 5 seconds
    setInterval(check_deleted_comments, 5000);
});

const get_params = new URLSearchParams(window.location.search);
let postId = get_params.get('postId');
let last_commentid = 0;
let uid = undefined;
let utype = undefined;
let commentids = new Set();

//write load_comments
function load_comments() {
    
    let comments = $('.thread-comments');
    $.ajax({
        type: 'POST',
        url: '../scripts/load_comments.php',
        data: {postId: postId},
        success: function (data) {
            comments.empty();
            if (data.error !== undefined) {
                console.error(data.error);
                comments.append($('<p>').text(data.error));
            } else {
                uid = data.uid;
                utype = data.utype;
                if (data.comments.length == 0) {
                    comments.append($('<p>').addClass('no-com-msg').text("No comments have been made for this post."));
                } else {
                    data.comments.forEach(function (comment) {
                        commentids.add(comment.comId);
                        if(last_commentid < comment.comId) last_commentid = comment.comId;
                        //main comment container
                        let comment_container = $('<div>').attr('id', comment.comId);
                        comment_container.addClass('thread-comment-container');
                        
                        //profile info container
                        let profile_container = $('<div>');
                        profile_container.addClass('thread-comment-profile');
                        comment_container.append(profile_container);
                        //profile image
                        let pfp_img = $('<img>');
                        pfp_img.attr('src', comment.pfp);
                        pfp_img.attr('alt', "Profile Photo");
                        profile_container.append(pfp_img);
                        // username
                        let i = $('<i>');
                        let a = $('<a>');
                        if (uid == comment.userId) {
                            a.attr('href', './my_profile.php');
                        } else {
                            a.attr('href', `./profile.php?uName=${encodeURIComponent(comment.userName)}`);
                        }
                        a.text(comment.userName);
                        i.append(a);
                        if (comment.userType == 1) {
                            let span = $('<span>').addClass("mod").text(" [MOD]");
                            i.append(span);
                        }
                        i.append(' on ');
                        let time = $('<time>').text(comment.comDate);
                        i.append(time);
                        profile_container.append(i);

                        //the comment text
                        let thread_comment = $('<p>').addClass('thread-comment').text(comment.comText);
                        comment_container.append(thread_comment);
                        comments.append(comment_container);
                        //dropdown
                        if (uid != null) {
                            let com_more_options = $('<div>').addClass('com-more-options').attr('data-commentid', comment.comId);
                            com_more_options.click(function (event) {
                                event.preventDefault(); 
                                let commentid = $(this).data('commentid');
                                $(`.dropdown-com-${commentid}`).toggle("show");
                            });
                            let icon = $('<i>').addClass("fa-solid fa-ellipsis");
                            com_more_options.append(icon);
                            let dropdown = $('<div>').addClass(`dropdown-com-${comment.comId}`).attr('id', 'dropdown-menu').css('top', '3em');
                            dropdown.append($('<a>').attr('href', "").addClass('reply-icon').attr('id', `reply-icon-${comment.comId}`).attr('data-commentid', comment.comId).text('Reply'));
                            if (uid == comment.userId)
                                dropdown.append($('<a>').attr('href', `../scripts/delete_comment.php?postId=${postId}&comId=${comment.comId}`).text('Delete'));
                            comment_container.append(com_more_options, dropdown);
                        }
                        // to load subcomments
                        $.ajax({
                            type: 'POST',
                            url: "../scripts/load_subcomments.php",
                            data: { comId: comment.comId },
                            success: function (data) {
                                if (data.error !== undefined) {
                                    console.error(data.error);
                                    comments.append($('<p>').text(data.error));
                                } else {
                                    data.subcomments.forEach(function (subcomment) {
                                        commentids.add(subcomment.comId);
                                        if(last_commentid < subcomment.comId) last_commentid = subcomment.comId;
                                        //main comment container
                                        let subcomment_container = $('<div>').attr('id', subcomment.comId);
                                        subcomment_container.addClass('thread-comment-container');
                                        
                                        //profile info container
                                        let profile_container = $('<div>');
                                        profile_container.addClass('thread-comment-profile');
                                        subcomment_container.append(profile_container);
                                        //profile image
                                        let pfp_img = $('<img>');
                                        pfp_img.attr('src', subcomment.pfp);
                                        pfp_img.attr('alt', "Profile Photo");
                                        profile_container.append(pfp_img);
                                        // username
                                        let i = $('<i>');
                                        let a = $('<a>');
                                        if (uid == subcomment.userId) {
                                            a.attr('href', './my_profile.php');
                                        } else {
                                            a.attr('href', `./profile.php?uName=${encodeURIComponent(subcomment.userName)}`);
                                        }
                                        a.text(subcomment.userName);
                                        i.append(a);
                                        if (subcomment.userType == 1) {
                                            let span = $('<span>').addClass("mod").text(" [MOD]");
                                            i.append(span);
                                        }
                                        i.append(' on ');
                                        let time = $('<time>').text(subcomment.comDate);
                                        i.append(time);
                                        profile_container.append(i);

                                        //the comment text
                                        let thread_comment = $('<p>').addClass('thread-comment').text(subcomment.comText);
                                        subcomment_container.append(thread_comment);

                                        //dropdown
                                        if (uid != null) {
                                            let com_more_options = $('<div>').addClass('com-more-options').attr('data-commentid', subcomment.comId);
                                            com_more_options.click(function (event) {
                                                event.preventDefault(); 
                                                let commentid = $(this).data('commentid');
                                                $(`.dropdown-com-${commentid}`).toggle("show");
                                            });
                                            let icon = $('<i>').addClass("fa-solid fa-ellipsis");
                                            com_more_options.append(icon);
                                            let dropdown = $('<div>').addClass(`dropdown-com-${subcomment.comId}`).attr('id', 'dropdown-menu').css('top', '3em');
                                            dropdown.append($('<a>').attr('href', "").addClass('reply-icon').attr('id', `reply-icon-${comment.comId}`).attr('data-commentid', comment.comId).attr('data-username', subcomment.userName).text('Reply'));
                                            if (uid == subcomment.userId)
                                                dropdown.append($('<a>').attr('href', `../scripts/delete_comment.php?postId=${postId}&comId=${subcomment.comId}`).text('Delete'));
                                            subcomment_container.append(com_more_options, dropdown);
                                        }

                                        comment_container.append(subcomment_container);
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Sub Comment Error:', error);
                                console.log("status:", status);
                            }
                        });
                    });
                }
            }
        },
        error: function(xhr, status, error) {
            console.error('Comment Error:', error);
            console.log("status:", status);
        }
    });
}

function check_comments() {
    let comments = $('.thread-comments');
    $.ajax({
        type: 'POST',
        url: '../scripts/append_comments.php',
        data: { postId: postId, lastComId: last_commentid},
        success: function (data) {
            if (data.error !== undefined) {
                console.error(data.error);
            } else {
                data.comments.forEach(function (comment) {
                    $('.no-com-msg').remove();
                    commentids.add(comment.comId);
                    if (last_commentid < comment.comId) last_commentid = comment.comId;
                    let comment_container = $('<div>');
                    comment_container.addClass('thread-comment-container');
                    
                    //profile info container
                    let profile_container = $('<div>');
                    profile_container.addClass('thread-comment-profile');
                    comment_container.append(profile_container);
                    //profile image
                    let pfp_img = $('<img>');
                    pfp_img.attr('src', comment.pfp);
                    pfp_img.attr('alt', "Profile Photo");
                    profile_container.append(pfp_img);
                    // username
                    let i = $('<i>');
                    let a = $('<a>');
                    if (uid == comment.userId) {
                        a.attr('href', './my_profile.php');
                    } else {
                        a.attr('href', `./profile.php?uName=${encodeURIComponent(comment.userName)}`);
                    }
                    a.text(comment.userName);
                    i.append(a);
                    if (comment.userType == 1) {
                        let span = $('<span>').addClass("mod").text(" [MOD]");
                        i.append(span);
                    }
                    i.append(' on ');
                    let time = $('<time>').text(comment.comDate);
                    i.append(time);
                    profile_container.append(i);

                    //the comment text
                    let thread_comment = $('<p>').addClass('thread-comment').text(comment.comText);
                    comment_container.append(thread_comment);
                    comments.append(comment_container);
                    //dropdown
                    if (uid != null) {
                        let com_more_options = $('<div>').addClass('com-more-options').attr('data-commentid', comment.comId);
                        com_more_options.click(function (event) {
                            event.preventDefault();
                            let commentid = $(this).data('commentid');
                            $(`.dropdown-com-${commentid}`).toggle("show");
                        });
                        let icon = $('<i>').addClass("fa-solid fa-ellipsis");
                        com_more_options.append(icon);
                        let dropdown = $('<div>').addClass(`dropdown-com-${comment.comId}`).attr('id', 'dropdown-menu').css('top', '3em');
                        dropdown.append($('<a>').attr('href', "").addClass('reply-icon').attr('id', `reply-icon-${comment.comId}`).attr('data-commentid', comment.comId).text('Reply'));
                        if (uid == comment.userId)
                            dropdown.append($('<a>').attr('href', `../scripts/delete_comment.php?postId=${postId}&comId=${comment.comId}`).text('Delete'));
                        comment_container.append(com_more_options, dropdown);
                    }
                    if (comment.parentComId == null) {
                        comment_container.attr('id', comment.comId);
                        comments.prepend(comment_container);
                    } else {
                        $(`#${comment.parentComId}`).append(comment_container);
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            console.log("status:", status);
            console.log(xhr.responseText);
        }
    });
}

function check_deleted_comments() {
    commentids.forEach(function (comId) {
        $.ajax({
            type: 'POST',
            url: '../scripts/check_deleted_comments.php',
            data: { comId: comId },
            success: function (data) {
                if (!data.com_exists) {
                    $(`#${comId}`).remove();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                console.log("status:", status);
                console.log(xhr.responseText);
            }
        });
    });
}