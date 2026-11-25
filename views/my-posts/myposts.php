<?php 
    session_start();

    if (!isset($_SESSION["isLoggedIn"])) {
        header("Location: ../index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Camel: My Posts</title>
    <link rel="stylesheet" href="../../styles/myposts.css" />
    <link rel="stylesheet" href="../../styles/navigationbar.css" />
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="../../images/logo/content-camel.png">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    
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
        <h1>My Posts</h1>
        <form class="container__search" onsubmit="doSearch()">
            <div class="search__basic">
                <input id='searchValue' placeholder='Search...'>
                <button class="search__submit-button" type="submit"><i class='fa fa-search'></i></button>
            </div>
            <div class="search__advanced">
                <button onclick="toggleCollapsible()">Advanced search <i class="advanced__collapsible-icon fa-solid fa-angle-down"></i></button>
                <div class="advanced__inputs">
                    <div class="advanced__date">
                        <h3>Date range</h3>
                        <div class="date__input">
                            <div>
                                <p>From:</p>
                                <input id="dateFrom" onblur="updateDateTo()" type="date">
                            </div>
                            <div>
                                <p>To:</p>
                                <input id="dateTo" onblur="updateDateFrom()" type="date">
                            </div>
                        </div>
                    </div>
                    <div class="advanced__status">
                        <h3>Status</h3>
                        <select id="isPosted" name="status">
                            <option label="none" value="-1"></option>
                            <option value="0">Draft</option>
                            <option value="1">Posted</option>
                        </select>
                    </div>
                    <div class="advanced__category">
                        <h3>Category</h3>
                        <?php
                            // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
                            $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");
                            
                            if (mysqli_connect_errno()) {
                                echo "Failed to connect to MySQL: " . mysqli_connect_error();
                            }

                            $retrieveCategoriesQuery = "SELECT categoryId, name FROM ContentCamelCategories WHERE userID = '" . $_SESSION["userId"] . "'";
                            
                            $retrieveCategoriesResult = mysqli_query($mysqli, $retrieveCategoriesQuery);
                            echo "<input list='categories' id='category' maxlength='30' placeholder='Select Category...'>";
                            echo "<datalist id='categories'>";
                            $categoryInfo = null;
                            
                            echo "<option value='uncategorised'>";
                            while ($row = mysqli_fetch_assoc($retrieveCategoriesResult)) {
                                echo "<option value='" . $row["name"] . "'>";
                                $categoryInfo[$row["categoryId"]] = $row["name"];
                            }

                            echo "</datalist>";
                            setcookie("categories", json_encode($categoryInfo));
                        ?>
                    </div>
                </div>
            </div>
        </form>
        <div class="container__results"></div>
        <script src="../edit-post/scripts/savePostToLocalStorage.js"></script>
        <script src="./scripts/doSearch.js"></script>
        <script src="./scripts/toggleCollapsible.js"></script>
        <script src="./scripts/updateDateInputs.js"></script>
        <script src="./scripts/windowResizeEventListener.js"></script>
        <script src="../create-post/scripts/isPostedBackgroundChanger.js"></script>
        <script>doSearch()</script>
    </div>
</body>
</html>