<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/logo.png">
</head>
<body>
    <nav id="top-bar">
        <a href="./discussion.html"><img src="../img/logo.png" alt="Pondr Logo" id="top-bar-logo"></a>
        <div id="top-search-bar">
            <form method="GET" action="discussionLoggedIn.html">
                <input type="text" name="search" placeholder="Search for Users and Threads" />
                <button type="submit" class="form-button">Search</button>
            </form>
        </div>
        <a href="profile.html"><img src="../img/pfp-3.jpg" id="top-search-bar-pfp"> </a>
    </nav>
    <main class="center-container">
        <section class="form-container">
            <form action="POST">
                <legend>New Post</legend>
                <div class="form-item">
                    <label for="post_title">Post Title</label>
                    <input type="text" placeholder="Enter your Post Title" name="post_title" required>
                </div>
                <div class="form-item">
                    <label for="post_text">Post Text</label>
                    <textarea name="post_text" cols="30" rows="10" required placeholder="Enter Post Text Here"></textarea>
                </div>
                <div class="form-item">
                    <label for="post_link">Any link? (Optional)</label>
                    <input type="text" name="post_link" placeholder="Enter Link Here"/>
                </div>
                <div class="form-item">
                    <label for="post_image">Any Images to your post? (Optional)</label>
                    <input type="file" name="post_image" accept="image/*" >
                </div>
                <div class="form-item">
                    <label for="category">Choose a Category:</label>
                    <select name="category">
                        <option value="none">None</option>
                        <option value="cat-1">Category 1</option>
                        <option value="cat-2">Category 2</option>
                        <option value="cat-3">Category 3</option>
                        <option value="cat-4">Category 4</option>
                        <option value="cat-5">Category 5</option>
                        <option value="cat-6">Category 6</option>
                        <option value="cat-7">Category 7</option>
                        
                    </select>
                </div>
                <div class="form-item">
                    <button type="submit" class="form-button">Post</button>
                    <button type="reset" class="form-button">Reset</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>