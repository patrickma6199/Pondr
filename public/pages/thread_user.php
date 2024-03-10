<?php
session_start();
require_once '../scripts/dbconfig.php';
$pid = $_SESSION['pid'];
$uid = $_SESSION['uid'] ;



if(!isset($uid)){


if($_SERVER["REQUEST_METHOD"] == "GET"){
    // pid
    // uid is set, send to javascript which can send it to likes.php
    



}
}
else {
    header('Location: ../pages/register.php')
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Thread Name</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/threads.css">
    <link rel="icon" href="../img/logo.png">
    <script src="../scripts/like_button.js"></script>
    <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
    
</head>
<body>
    <nav id="top-bar">
        <a href="./discussionLoggedIn.html"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
        <div id="top-search-bar">
            <form method="GET" action="discussionLoggedIn.html">
                <input type="text" name="search" placeholder="Search for Users and Threads" />
                <button type="submit" class="form-button">Search</button>
            </form>
        </div>
        <a href="profile.html"><img src="../img/pfp-3.jpg" id="top-search-bar-pfp"> </a>
    </nav>
    <main class="column-container margin-down">
        <div class="thread-container">
            <article>
                <img src="../img/cat.jpg" class="thread-img">
                <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>
                <i>Posted by: <a href="./secondaryProfile.html">username</a> on <time>January 1, 1970</time> under Sports</i>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. 
                    Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornar
                    e arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus 
                    est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor
                    sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis
                    tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum 
                    congue massa. Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa.
                    Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet.
                    Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornar
                    e arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet.
                    Phasellus
                    est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum
                    dolor
                    sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis
                    quis
                    tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur
                    adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum
                    congue massa. Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa.
                    Praesent vitae varius nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
            </article>
            <div id="icon-buttons">
                <a href="" class="link-button" id="like-button" onclick="increaseLikeCount(event);"><i class="fa-regular fa-heart"></i> Like |  <span id="like-count"> 0 </span></a>
                <a href="" class="link-button"><i class="fa-solid fa-comment"></i> Comment</a>
                
            </div>
        </div>
        <div class="thread-comments">
            <article class="thread-comment-container">
                <div class="thread-comment-profile">
                    <img src="../img/stock_profile_photo.png" alt="profile photo">
                    <i>username on <time>January 1, 1970</time></i>
                </div>
                <p class="thread-comment">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
                <div>
                    <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                </div>
                
                <div class="thread-comment-container">
                    <div class="thread-comment-profile">
                        <img src="../img/stock_profile_photo.png" alt="profile photo">
                        <i>username on <time>January 1, 1970</time></i>
                    </div>
                        <p class="thread-comment">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                            finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                            nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        
                            <div>
                                <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                            
                            </div>
                    
                </div>
                <div class="thread-comment-container">
                    <div class="thread-comment-profile">
                        <img src="../img/stock_profile_photo.png" alt="profile photo">
                        <i>username on <time>January 1, 1970</time></i>
                    </div>
                    <p class="thread-comment">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                        finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                        nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                    <div>
                        <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                    
                    </div>
                </div>
            </article>
            <article class="thread-comment-container">
                <div class="thread-comment-profile">
                    <img src="../img/stock_profile_photo.png" alt="profile photo">
                    <i>username on <time>January 1, 1970</time></i>
                </div>
                <p class="thread-comment">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
                <div>
                    <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                
                </div>
                
                <div class="thread-comment-container">
                    <div class="thread-comment-profile">
                        <img src="../img/stock_profile_photo.png" alt="profile photo">
                        <i>username on <time>January 1, 1970</time></i>
                    </div>
                    <p class="thread-comment">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                        finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                        nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                    <div>
                        <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                    
                    </div>
                </div>
            </article>
            <article class="thread-comment-container">
                <div class="thread-comment-profile">
                    <img src="../img/stock_profile_photo.png" alt="profile photo">
                    <i>username on <time>January 1, 1970</time></i>
                </div>
                <p class="thread-comment">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
                <div>
                    <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                
                </div>
            </article>
            <article class="thread-comment-container">
                <div class="thread-comment-profile">
                    <img src="../img/stock_profile_photo.png" alt="profile photo">
                    <i>username on <time>January 1, 1970</time></i>
                </div>
                <p class="thread-comment">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl
                    finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius
                    nunc, sed ornare arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
                <div>
                    <a href="" class="link-button" id="reply-icon"><i class="fa-solid fa-reply"></i> Reply</a>
                
                </div>
            </article>
        </div>
    </main>
</body>
</html>