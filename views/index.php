<?php
    session_start();

    if (isset($_SESSION["isLoggedIn"])) {
        header("Location: ./my-posts/myposts.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Camel: Home</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="icon" href="../images/logo/content-camel.png">
</head>
<body class="home__body">
    <div class="body__container">
        <img alt="Content Camel Logo" src="../images/logo/content-camel.png">
        <h1>Content Camel</h1>
        <h2>THE place to manage and store your content</h2>
        <div class="home__buttons">
            <button onclick="window.location='./accounts/register.php'" class="home__button">Register</button>
            <button onclick="window.location='./accounts/login.php'" class="home__button">Log in</button>
        </div>
    </div>
</body>
</html>