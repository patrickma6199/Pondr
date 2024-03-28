<?php
session_start();
ini_set('display_errors', 1);

unset($_SESSION['bc_title']);
unset($_SESSION['bc_link']);

$pageTitle = "IGNORE";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login/Sign Up</title>
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="icon" href="../img/logo.png">
        <style>
            body{
                animation: fadeBg 3s ease-in;
                background-image: url(../img/background-2.png);
                background-position: center center; 
                background-repeat: no-repeat; 
                background-attachment: fixed; 
                background-size: cover; 
            }

            @keyframes fadeBg {
                from {
                    background-color: 0;}
                to {
                    background-image: 1;
            }
        }
            .logo-container {
                display: flex;
                flex-direction: column; 
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
                text-align: center;
            }
          
            .explore-button {
                display: inline-block; 
                width: 150px;
                margin: 2em auto 0;
                text-align: center;
                background-color: transparent; 
                border: 2px solid white; 
                padding: 0.5em 1em;
                color: white; 
                text-decoration: none; 
                transition: all 0.3s ease-in-out; /* Smooth transition for hover effects */
            }

                .explore-button:hover {
                background-color: transparent; 
                color: var(--background-color); 
                color: white;
            }
          </style>
    </head>
<body>

<div class="logo-container">
    <img src="../img/mainLogo.png" alt="Pondr Logo" class="logo" style="width: 400px; height: auto;"> 
    <a href="discussion.php" class="link-button explore-button">Explore Ponds</a> 
</div>

</body>
</html>
