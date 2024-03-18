<?php
session_start();
ini_set('display_errors', 1);
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
    <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require_once '../scripts/header.php'; //for dynamic header ?>
        <main class="column-container margin-down">
        <div class="thread-container">
            <article>
                <img src="../img/cat.jpg" class="thread-img">
                <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>
                <i>Posted by: <a href="./secondaryProfile.php">username</a> on <time>January 1, 1970</time> under Sports</i>
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
                <a href="" class="link-button"><i class="fas fa-flag"></i> Flag</a>
                <a href="" class="link-button"><i class="fas fa-trash-alt"></i> Delete</a>
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
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
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
                                <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                                <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
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
                        <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                        <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
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
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
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
                        <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                        <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
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
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
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
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-trash-alt"></i> Delete</a>
                    <a href="" class="link-button" id="reply-icon"><i class="fas fa-flag"></i> Flag</a>
                </div>
            </article>
        </div>
    </main>
</body>
</html>