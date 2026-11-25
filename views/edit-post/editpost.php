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
    
    if (array_key_exists("deletePost", $_POST)) {
        $deletePostQuery = "DELETE FROM ContentCamelPosts WHERE postId='" . $_GET['postId'] . "'";
        mysqli_query($mysqli, $deletePostQuery);
        echo "<script>alert('Post deleted!'); window.location.href='../my-posts/myposts.php'</script>";
    }

    include "../../includes/categoryhandler.php";

    if (isset($_POST["title"]) && isset($_POST["content"])) {
        // Check it's not the most recent one so we can prevent duplicates from refreshing
        if (isset($_COOKIE["previousTitle"]) && isset($_COOKIE["previousContent"])) {
            if ($_COOKIE["previousTitle"] != $_POST["title"] 
                || $_COOKIE["previousContent"] != $_POST["content"]
                || $_COOKIE["previousCategoryId"] != $categoryId
                || $_COOKIE["previousIsPosted"] != $_POST["isPosted"]) {
                update_post($mysqli, $retrieveCategoriesQuery, $categoryId);
            }
        } else {
            update_post($mysqli, $retrieveCategoriesQuery, $categoryId);
        }
    }
    
    function update_post($mysqli, $retrieveCategoriesQuery, $categoryId) {
        if (array_key_exists("updatePost", $_POST)) {
            $updatePostQuery;
    
            $updatePostQuery = "UPDATE ContentCamelPosts SET title='" . htmlentities($_POST["title"]) 
                . "', content='" . htmlentities($_POST["content"]) 
                . "', categoryId=" . $categoryId
                . ", isPosted=". $_POST["isPosted"] 
                . " WHERE userId='" . $_SESSION["userId"] . "' AND postId='" . $_GET["postId"] . "'";

            $updatePostResult = mysqli_query($mysqli, $updatePostQuery);
            setcookie("previousTitle", $_POST["title"]); 
            setcookie("previousContent", $_POST["content"]); 
            setcookie("previousCategoryId", $categoryId); 
            setcookie("previousIsPosted", $_POST["isPosted"]); 
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Camel: Edit Post</title>
    <link rel="stylesheet" href="../../styles/navigationbar.css" />
    <link rel="stylesheet" href="../../styles/main.css" />
    <link rel="stylesheet" href="../../styles/createpost.css" />
    <link rel="stylesheet" href="../../styles/editpost.css" />
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
            <a href="../create-post/createpost.php">Create a New Post</a>
            <a href="../logout.php">Log Out</a>
        </div>
    </nav>
    <div class="main__container">
        <a class="container__back-link" href="../my-posts/myposts.php">&lt; Back to My Posts</a>
        <h1>Edit Post</h1>
        <form 
            method="post" 
            action="<?=$_SERVER['PHP_SELF'] . "?postId=" . $_GET['postId'] . "&categoryId=" . $_GET['categoryId'] ?>" 
            onload="loadPost()" 
            onsubmit="if (shouldDelete(event.submitter) === false) return false; saveUpdatedPostToLocalStorage();">
            <p class="container__character-count">0/60</p>
            <input 
                class='container__title-input' 
                name='title'
                maxlength='60'
                placeholder='Title...'
                required>
            <p class="container__character-count">0/3000</p>
            <textarea 
                class="container__content-input" 
                name="content"
                maxlength="3000"
                placeholder="What do you want to talk about?"
                required></textarea>
            <div class="form__buttons">
                <select class="form__select-is-posted" name="isPosted">
                    <option value="0">Draft</option>
                    <option value="1">Posted</option>
                </select>
                <?php
                    // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
                    $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");
                    
                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                    }

                    $retrieveCategoriesQuery = "SELECT categoryId, name FROM ContentCamelCategories WHERE userID = '" . $_SESSION["userId"] . "'";
                    $retrieveCategoriesResult = mysqli_query($mysqli, $retrieveCategoriesQuery);
                    echo "<input class='form__select-category' list='categories' name='category' maxlength='30' placeholder='Select Category...'>";
                    echo "<datalist id='categories'>";

                    while ($row = mysqli_fetch_assoc($retrieveCategoriesResult)) {
                        echo "<option value='" . $row["name"] . "'>";
                    }

                    echo "</datalist>";
                ?>
                <input
                    class="form__submit form__submit-delete"
                    name="deletePost"
                    type="submit"
                    value="Delete post"/>
                <input 
                    class="form__submit"
                    name="updatePost" 
                    type="submit" 
                    value="Update post"/>
            </div>
        </form>
    </div> 
    <script src="../create-post/scripts/characterCount.js"></script>
    <script src="../create-post/scripts/isPostedBackgroundChanger.js"></script>
    <script src="../edit-post/scripts/saveUpdatedPostToLocalStorage.js"></script>
    <script src="../edit-post/scripts/loadPost.js"></script>
    <script>
        loadPost();

        function shouldDelete(submitter) {
            if (submitter === document.querySelector("input.form__submit.form__submit-delete")) {
                const shouldDelete = confirm("Are you sure you want to delete this post?");

                if (!shouldDelete) {
                    return false;
                }
            }
        }
    </script>
</body>
</html>