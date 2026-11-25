<?php 
    session_start();

    if (!isset($_SESSION["isLoggedIn"])) {
        header("Location: ../index.php");
        exit;
    }

    // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
    $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");
                    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    include "../../includes/categoryhandler.php";
    
    if (isset($_POST["title"]) && isset($_POST["content"])) {
        // Check it's not the most recent one so we can prevent duplicates from refreshing
        if (isset($_COOKIE["previousTitle"]) && isset($_COOKIE["previousContent"])) {
            if ($_COOKIE["previousTitle"] != $_POST["title"] || $_COOKIE["previousContent"] != $_POST["content"]) {
                save_post($mysqli, $retrieveCategoriesQuery, $categoryId);
            }
        } else {
            save_post($mysqli, $retrieveCategoriesQuery, $categoryId);
        }
    }
    
    function save_post($mysqli, $retrieveCategoriesQuery, $categoryId) {
        $date = date('Y-m-d H:i:s');
        $insertNewPostQuery = "INSERT INTO `ContentCamelPosts`(`postId`, `userId`, `title`, `content`, `dateCreated`, `categoryId`, `isPosted`) VALUES ('" . uniqid() . "','". $_SESSION["userId"] ."', '" . htmlentities($_POST["title"]) . "', '" . htmlentities($_POST["content"]) . "', '" . $date . "', " . $categoryId . ", ". $_POST["status"] . ")";
        $insertNewPostResult = mysqli_query($mysqli, $insertNewPostQuery);
        setcookie("previousTitle", $_POST["title"]); 
        setcookie("previousContent", $_POST["content"]); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Camel: Create a New Post</title>
    <link rel="stylesheet" href="../../styles/navigationbar.css" />
    <link rel="stylesheet" href="../../styles/main.css" />
    <link rel="stylesheet" href="../../styles/createpost.css" />
    <link rel="icon" href="../../images/logo/content-camel.png" />
</head>
<body>
    <nav>
        <div class="navigation__logo-container">
            <img alt="Content Camel Logo" src="../../images/logo/content-camel.png">
            <p>Content Camel</p>
        </div>
        <div class="navigation__pages-container">
            <a href="../my-posts/myposts.php">My Posts</a>
            <a href="../views/create-post/createpost.php">Create a New Post</a>
            <a href="../logout.php">Log Out</a>
        </div>
    </nav>
    <div class="main__container">
        <h1>Create a New Post</h1>
        <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
            <p class="container__character-count">0/60</p>
            <input 
                class="container__title-input" 
                name="title"
                maxlength="60"
                placeholder="Title..."
                required>
            <p class="container__character-count">0/3000</p>
            <textarea 
                class="container__content-input" 
                name="content"
                maxlength="3000"
                placeholder="What do you want to talk about?"
                required></textarea>
            <div class="form__buttons">
                <select name="status">
                    <option value="0">Draft</option>
                    <option value="1">Posted</option>
                </select>
                <?php
                    // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
                    $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");
                    
                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    $retrieveCategoriesResult = mysqli_query($mysqli, $retrieveCategoriesQuery);
                    echo "<input class='form__select-category' list='categories' name='category' maxlength='30' placeholder='Select Category...'>";
                    echo "<datalist id='categories'>";

                    while ($row = mysqli_fetch_assoc($retrieveCategoriesResult)) {
                        echo "<option value='" . $row["name"] . "'>";
                    }

                    echo "</datalist>";
                ?>
                <input 
                    class="form__submit"
                    name="savePost" 
                    type="submit" 
                    value="Save post"/>
            </div>
        </form>
    </div> 
    <script src="./scripts/characterCount.js"></script>
    <script src="./scripts/isPostedBackgroundChanger.js"></script>
</body>
</html>