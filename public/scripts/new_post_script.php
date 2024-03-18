<?php
session_start();
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$utype = (isset ($_SESSION['utype'])) ? $_SESSION['utype'] : null;
$uid = (isset ($_SESSION['uid'])) ? $_SESSION['uid'] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['post_title']) && isset($_POST['post_text']) && isset($_POST['post_link']) && isset($_POST['category'])){
        $postTitle = $_POST['post_title'];
        $postText = $_POST['post_text'];
        $postLink = ($_POST['post_link'] == "") ? null :$_POST['post_link'];
        $category = ($_POST['category'] == "none") ? null:$_POST['category'];
    } else {
        $_SESSION['newPostMessage'] = "<p>Insufficient information submitted to create a post.</p>";
        exit (header('Location: ../pages/new_post.php'));
    }

    if (isset ($_FILES['post_image'])) {
        if ($_FILES['post_image']['error'] == UPLOAD_ERR_OK) {
            $validExt = array("jpg", "jpeg", "png");
            $validMime = array("image/jpeg", "image/png");
            $filenameArray = explode(".", $_FILES['post_image']['name']);
            $extension = end($filenameArray);
            if (in_array($_FILES['post_image']['type'], $validMime) && in_array($extension,$validExt)) {
                if ($_FILES['post_image']['size'] <= 10485760) { // if they bypass the hidden form item
                    //generating unique key as filename
                    $imgUrl = '../img/posts/' . bin2hex(random_bytes(16)) . "." . $extension;
                    $unique = false;

                    while(!$unique) {
                        //check if key exists already for another user
                        $sql = "SELECT * FROM posts WHERE img = ?;";
                        $prstmt = $conn->prepare($sql);
                        $prstmt->bind_param("s",$imgUrl);
                        
                        try{
                            $prstmt->execute();
                            // if already used, regenerate
                            if ($prstmt->fetch()) {
                                $imgUrl = '../img/posts/' . bin2hex(random_bytes(16)) . "." . $extension;
                            } else {
                                $prstmt->close();
                                $unique = true;
                            }
                        } catch(mysqli_sql_exception $e){
                            $_SESSION['newPostMessage'] = "<p>An error occurred while trying to save your image. Please try again.</p>";
                            $prstmt->close();
                            $conn->close();
                            exit(header("Location: ../pages/new_post.php"));
                        }
                    }
                } else {
                    $_SESSION['newPostMessage'] = "<p>Your post image must be a maximum of 10MB in size.</p>";
                    exit(header("Location: ../pages/new_post.php"));
                }
            } else {
                $_SESSION['newPostMessage'] = "<p>Your post image needs to be in jpeg or png format.</p>";
                exit(header("Location: ../pages/new_post.php"));
            }
        } else {
            if ($_FILES['post_image']['error'] == UPLOAD_ERR_FORM_SIZE) {
                $_SESSION['newPostMessage'] = "<p>Your post image must be a maximum of 10MB in size.</p>";
                exit(header("Location: ../pages/new_post.php"));
            }
            $_SESSION['newPostMessage'] = "<p>An error occured while trying to retrieve the post image from your submission. Please try again.</p>";
            exit(header("Location: ../pages/new_post.php"));
        }
        // resizing and saving image (getting to this portion of the code means that the post image was of valid size and type)
        $original = $_FILES['post_image']['tmp_name'];
        $oSize = getimagesize($original);
        $oWidth = $oSize[0];
        $oHeight = $oSize[1];
        $resizeDim = 960; //to make it into a square (960pxx960px)

        if ($extension == "jpeg" || $extension == "jpg") {
            $oImage = imagecreatefromjpeg($original);
            $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
            imagecopyresampled($rImage,$oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth,$oHeight);
            imagejpeg($rImage, $imgUrl);
        } else { // must be a png if not jpg
            $oImage = imagecreatefrompng($original);
            $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
            imagealphablending($rImage, false);
            imagesavealpha($rImage, true);
            imagecopyresampled($rImage,$oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth,$oHeight);
            imagepng($rImage,$imgUrl);
        }
    } else {
        $imgUrl = null;
    }

    $sql = "INSERT INTO posts(userId,postDate,title,text,img,link,catId) VALUES (?,NOW(),?,?,?,?,?);";
    $prstmt = $conn->prepare($sql);
    $prstmt->bind_param('ssssss', $uid,$postTitle,$postText,$imgUrl,$postLink,$category);
    try {
        $prstmt->execute();
        $_SESSION['newPostMessage'] = "<p>Your post was successfully posted!</p>";
    } catch(mysqli_sql_exception $e) {
        $_SESSION['newPostMessage'] = "<p>An error occured while trying to create your post. Please try again.</p>";
        $prstmt->close();
        $conn->close();
        exit(header('Location: ../pages/new_post.php'));
    }
    $prstmt->close();
    $conn->close();

    exit(header('Location: ../pages/new_post.php'));

} else {
    exit (header('Location: ../index.php'));
}

?>