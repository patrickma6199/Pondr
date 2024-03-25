<?php
session_start();
ini_set('display_errors', 1);
require_once './dbconfig.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$utype = $_SESSION['utype'] ?? null;
$uid = $_SESSION['uid'] ?? null;

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
                                $imageSet = true;
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
                    $conn->close();
                    exit(header("Location: ../pages/new_post.php"));
                }
            } else {
                $_SESSION['newPostMessage'] = "<p>Your post image needs to be in jpeg or png format.</p>";
                $conn->close();
                exit(header("Location: ../pages/new_post.php"));
            }
        } else {
            if ($_FILES['post_image']['error'] == UPLOAD_ERR_FORM_SIZE) {
                $_SESSION['newPostMessage'] = "<p>Your post image must be a maximum of 10MB in size.</p>";
                $conn->close();
                exit(header("Location: ../pages/new_post.php"));
            } else if ($_FILES['post_image']['error'] == UPLOAD_ERR_NO_FILE) {
                $imgUrl = null;
                $imageSet = false;
            } else {
                $_SESSION['newPostMessage'] = "<p>An error occured while trying to retrieve the post image from your submission. Please try again.</p>";
                $conn->close();
                exit (header("Location: ../pages/new_post.php"));
            }
        }
    } else {
        $imgUrl = null;
        $imageSet = false;
    }

    $conn->begin_transaction();
    $sql = "INSERT INTO posts(userId,postDate,title,text,img,link,catId) VALUES (?,NOW(),?,?,?,?,?);";
    $prstmt = $conn->prepare($sql);
    $prstmt->bind_param('ssssss', $uid,$postTitle,$postText,$imgUrl,$postLink,$category);
    try {
        $prstmt->execute();
        if (isset ($category)) {
            $sql = "UPDATE categories SET count = count + 1 WHERE catId=?;";
            $prstmt = $conn->prepare($sql);
            $prstmt->bind_param("s", $category);
            $prstmt->execute();
        }

        if ($imageSet) {
            if (extension_loaded('gd')) {
                // resizing and saving image (getting to this portion of the code means that the post image was of valid size and type)
                $original = $_FILES['post_image']['tmp_name'];
                $oSize = getimagesize($original);
                if (!$oSize) {
                    throw new Exception("Failed to get image size.");
                }
                $oWidth = $oSize[0];
                $oHeight = $oSize[1];
                $resizeDim = 960; //to make it into a square (960px x 960px)

                if ($extension == "jpeg" || $extension == "jpg") {
                    $oImage = imagecreatefromjpeg($original);
                    if (!$oImage) {
                        throw new Exception("Failed to create JPEG image from file.");
                    }
                } else { // must be a png if not jpg
                    $oImage = imagecreatefrompng($original);
                    if (!$oImage) {
                        throw new Exception("Failed to create PNG image from file.");
                    }
                }

                $rImage = imagecreatetruecolor($resizeDim, $resizeDim);
                if (!$rImage) {
                    throw new Exception("Failed to create truecolor image.");
                }

                if (!imagecopyresampled($rImage, $oImage, 0, 0, 0, 0, $resizeDim, $resizeDim, $oWidth, $oHeight)) {
                    throw new Exception("Failed to resample image.");
                }

                if ($extension == "jpeg" || $extension == "jpg") {
                    if (!imagejpeg($rImage, $imgUrl)) {
                        throw new Exception("Failed to save JPEG image.");
                    }
                } else { // must be a png if not jpg
                    imagealphablending($rImage, false);
                    imagesavealpha($rImage, true);
                    if (!imagepng($rImage, $imgUrl)) {
                        throw new Exception("Failed to save PNG image.");
                    }
                }
            } else {
                if (!move_uploaded_file($_FILES['post_image']['tmp_name'], $imgUrl)) {
                    throw new Exception("Failed to move uploaded file.");
                }
            }
        }
        $conn->commit();
        $_SESSION['discussionMessage'] = "<p class=\"fading-message\" id=\"post-success\">Your post was successfully posted!</p>";
    } catch(Exception $e) {
        $message = $e->getMessage();
        $_SESSION['newPostMessage'] = "<p>An error occured while trying to create your post. Please try again. Error: $message</p>";
        $conn->rollback();
        $prstmt->close();
        $conn->close();
        exit(header('Location: ../pages/new_post.php'));
    }
    $prstmt->close();
    $conn->close();
    exit(header('Location: ../pages/discussion.php'));

} else {
    $conn->close();
    exit (header('Location: ../index.php'));
}

?>