<?php
require_once 'public/scripts/dbconfig.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/discussion.css">
    <link rel="icon" href="../img/logo.png">
    <title>Pondr</title>
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
    <main class="center-container margin-down">
        <section class="side-container">
            <a href="new_post.html" class="link-button" style="padding: 1em 0em;">Make a New Post</a>
            <div>
                <h3>Filter by Category: </h3>
                <ul>
                    <li><a href="#">Category 1</a></li>
                    <li><a href="#">Category 2</a></li>
                    <li><a href="#">Category 3</a></li>
                    <li><a href="#">Category 4</a></li>
                    <li><a href="#">Category 5</a></li>
                    <li><a href="#">Category 6</a></li>
                    <li><a href="#">Category 7</a></li>
                </ul>
            </div>
        </section>

        <section class="discussion-container">
            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h2></a>
                    <i>Posted by: username on <time>January 1, 1970</time></i>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae nunc sed nisl finibus imperdiet. Phasellus est tellus, sagittis quis tortor a, interdum congue massa. Praesent vitae varius nunc, sed ornar e arcu. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </article>
                <img src="../img/cat.jpg">
            </div>
            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>Highly excited for the #Deadpool3 teaser</h2></a>
                    <i>Posted by: JohnDoe1234 on <time>January 1, 1970</time></i>
                    <p>Marvel, please don't disappoint this time ! </p>
                </article>
                <img src="../img/deadpool.jpg">
            </div>
            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>Sources tell me you can anticipate the #NHL DOPS to offer up some stern discipline to #LeafsForever Dman Morgan Reilly.</h2></a>
                    <i>Posted by: JohnDoe1234 on <time>January 1, 1970</time></i>
                    <p>Reilly should get suspended whatever. But for these last few weeks with blatant predatory head hits to get only phone hearings and then Reilly gets an in person is objectively wrong. It’s obviously because of the market attention and having to send a message </p>
                </article>
                <img src="../img/nhl.jpg">
            </div>
            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>It's incredible to think that today the world will get to see, on live television, Taylor Swift win her first Super Bowl ring</h2></a>
                    <i>Posted by: JohnDoe1234 on <time>January 1, 1970</time></i>
                    <p>An accomplishment never achieved by any other artist. This feat will forever enshrine her as the greatest musician in the history of music.</p>
                </article>
                <img src="../img/taylor.jpg">
            </div>
            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>I love eating eggs!</h2></a>
                    <i>Posted by: EggFella1234 on <time>January 1, 1970</time></i>
                    <p>Eggs are so nutritious, and tasty I just want to eat eggs for every meal. </p>
                </article>
                <img src="../img/egg-1.jpg">
            </div>
           
            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>Have y'all ever noticed how eggs are the perfect shape?</h2></a>
                    <i>Posted by: EggFella1234 on <time>January 1, 1970</time></i>
                    <p>Eggs just are the most perfect shape, I love how nice and smooth an egg feels on my hand!! It's just so cute and round.</p>
                </article>
                <img src="../img/egg-2.jpg">
            </div>

            <div class="mini-thread">
                <article>
                    <a href="./thread.html"><h2>Have y'all ever noticed how eggs are the perfect shape?</h2></a>
                    <i>Posted by: EggFella1234 on <time>January 1, 1970</time></i>
                    <p>Eggs just are the most perfect shape, I love how nice and smooth an egg feels on my hand!! It's just so cute and round.</p>
                </article>
                <img src="../img/egg-2.jpg">
            </div>

        </section>
    </main>
</body>
</html>