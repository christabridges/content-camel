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

    $categoryId = "";
    $getPostsQuery;

    if (array_key_exists("category", $_GET)) {
        $getCategoriesFromCookies = json_decode($_COOKIE["categories"], true);
        
        if ($_GET["category"] !== "uncategorised" && $getCategoriesFromCookies !== null) {
            $categoryId = array_search($_GET["category"], $getCategoriesFromCookies);
        }
    }

    if (array_key_exists("category", $_GET) && array_key_exists("isPosted", $_GET) && array_key_exists("dateFrom", $_GET) && array_key_exists("dateTo", $_GET) && array_key_exists("searchValue", $_GET)) {
        if ($_GET["dateFrom"] !== "" && $_GET["dateTo"] != "") {
            if ($_GET["isPosted"] != "-1" && ($categoryId != null && $_GET["category"] != "uncategorised")) {
                $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (dateCreated BETWEEN '" . $_GET["dateFrom"] . " 00:00:00' AND '" . $_GET["dateTo"] . " 23:59:59') AND (isPosted=" . $_GET["isPosted"] . ") AND categoryId='" . $categoryId . "')";
            } else if ($_GET["isPosted"] !== "-1" && $_GET["category"] == "uncategorised") {
                $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (dateCreated BETWEEN '" . $_GET["dateFrom"] . " 00:00:00' AND '" . $_GET["dateTo"] . " 23:59:59') AND (isPosted=" . $_GET["isPosted"] . ") AND categoryId IS NULL)";
            } else if ($_GET["isPosted"] !== "-1") {
                $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (dateCreated BETWEEN '" . $_GET["dateFrom"] . " 00:00:00' AND '" . $_GET["dateTo"] . " 23:59:59') AND (isPosted=" . $_GET["isPosted"] . "))";
            } else if($categoryId != null && $_GET["category"] != "uncategorised") {
                $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (dateCreated BETWEEN '" . $_GET["dateFrom"] . " 00:00:00' AND '" . $_GET["dateTo"] . " 23:59:59') AND categoryId='" . $categoryId . "')";
            } else if ($_GET["category"] == "uncategorised") {
                $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (dateCreated BETWEEN '" . $_GET["dateFrom"] . " 00:00:00' AND '" . $_GET["dateTo"] . " 23:59:59') AND categoryId IS NULL)";
            } else {
                $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (dateCreated BETWEEN '" . $_GET["dateFrom"] . " 00:00:00' AND '" . $_GET["dateTo"] . " 23:59:59'))";
            }
        } else if ($_GET["isPosted"] != "-1" && ($categoryId != null && $_GET["category"] != "uncategorised")) {
            $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (isPosted=" . $_GET["isPosted"] . ") AND categoryId='" . $categoryId . "')";
        } else if ($_GET["isPosted"] != "-1" && $_GET["category"] == "uncategorised") {
            $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (isPosted=" . $_GET["isPosted"] . ") AND categoryId IS NULL)";
        } else if ($_GET["isPosted"] != "-1") {
            $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND (isPosted=" . $_GET["isPosted"] . "))";
        } else if($categoryId != null && $_GET["category"] != "uncategorised") {
            $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND categoryId='" . $categoryId . "')";
        } else if ($_GET["category"] == "uncategorised") {
            $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND ((title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%') AND categoryId IS NULL)";
        } else {
            $getPostsQuery = "SELECT * FROM ContentCamelPosts WHERE (userID = '" . $_SESSION["userId"] . "') AND (title LIKE '%" . $_GET["searchValue"] . "%' OR content LIKE '%" . $_GET["searchValue"] . "%')";
        }
    } 

    $getPostsResult = mysqli_query($mysqli, $getPostsQuery);

    if (mysqli_num_rows($getPostsResult) == 0 && $_GET["searchValue"] === "") {
        echo "<div class='container__no-posts-container'>";
        echo "<h2>No posts yet, time to get writing!</h2>";
        echo "<p>\"The secret to getting ahead is getting started\" - Mark Twain</p>";
        echo "</div>";
    } else {
        
        echo "<div class='container__card-container'>";
        echo "<script>allPosts = []</script>";
    
        while ($row = mysqli_fetch_assoc($getPostsResult)) {
            $getCategoryQuery = "SELECT name FROM ContentCamelCategories WHERE userId='" . $_SESSION["userId"] . "' AND categoryId='" . $row["categoryId"] . "'"; 
            $getCategoryResult = mysqli_query($mysqli, $getCategoryQuery);
            $categoryName = mysqli_num_rows($getCategoryResult) > 0 ?  mysqli_fetch_assoc($getCategoryResult)["name"] : "";
            echo "<div 
                    onclick='savePostToLocalStorage(\"" . $row["title"] . "\", String.raw({raw: `" . $row["content"] . "`}), \"" . $categoryName . "\", \"" . $row["isPosted"] . "\"); 
                    window.location.href=\"../edit-post/editpost.php?postId=" . $row["postId"] . "&categoryId=" . $row["categoryId"] . "\"' 
                    class='card-container__post-card'>";
            echo "<img alt='LinkedIn card placeholder image' src='../../images/placeholders/LinkedIn Banner.png' />";
            echo "<div class='post-card__captions'>";
            echo "<p class='captions__title'>" . $row["title"] . "</p>";
            $contentSegment = substr($row["content"], 0, 90) . "...";
            echo "<p class='captions__content-segment'>" . $contentSegment . "</p>";
            echo "</div>";
            echo "<div class='post-card__additional-info'>";
            echo "<p " . ($row["isPosted"] == 0 ? "class='additional-info__is-posted--draft'>Draft" : "class='additional-info__is-posted--posted'>Posted") . "</p>";
            if ($categoryName !== "") {
                echo "<p class='additional-info__category'>" . $categoryName . "</p>";
            }
            echo "<script>allPosts.push({
                'postId': '" . $row["postId"]. "',
                'title': '" . $row["title"] . "',
                'content': '" . $row["content"] . "',
                'categoryId': '" . $row["categoryId"] . "',
                'categoryName': '". $categoryName . "',
                'isPosted': '" . $row["isPosted"] . "'})</script>";
            echo "</div>";
            echo "</div>";
        }   
    }
?>