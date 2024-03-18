<?php
    session_start();
    ini_set('display_errors', 1);
    require_once '../scripts/dbconfig.php';
    $utype = $_SESSION['utype'];
    $uid = $_SESSION['uid'];
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

   

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
    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/like_button.js"></script>
    <script src="../js/comment_count.js"></script>


    <script src="https://kit.fontawesome.com/cfd53e539d.js" crossorigin="anonymous"></script>
    
</head>
<body>
    <?php require_once '../scripts/header.php';  ?> 
    <main class="column-container margin-down">
        <div class="thread-container">
            <?php 
             if(isset($_GET['postId'])){
                $postId = $_GET['postId'];
             }
           
           
            $sql = "SELECT p.postId, p.userId, p.postDate, p.title, p.text, p.img, u.uName AS userName, c.name FROM posts p JOIN users u ON p.userId = u.userId JOIN categories c ON p.catId=c.catId WHERE p.postId = ?";
        
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param("i", $postId);
            $prstmt->execute();
            $prstmt->bind_result($postId,$userId,$postDate,$postTitle,$postText,$postImg,$userName,$category);
            if($prstmt->fetch()){
                echo "<article>";
                echo "<img src=\"$postImg\" class =\"thread-img\" >";
                echo "<h1> $postTitle </h1>";
                echo "<i>Posted by: <a href=\"./secondaryProfile.php\">$userName</a> on <time>$postDate</time> $category</i>";
                echo "<p> $postText </p>";
                echo " </article>";
                
            }else{
                echo "Post Does Not Exist";
            }

            ?>
            
            <div id="icon-buttons">
                <a href="" class="link-button" id="like-button" ><i class="fa-regular fa-heart"></i> Like |  <span id="like-count"> 0 </span></a>
                <a href="" class="link-button"><i class="fa-solid fa-comment"></i> Comment | <span id="comment-count"> 0 </span></a> 
                
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
