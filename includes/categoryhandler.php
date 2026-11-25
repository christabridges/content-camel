<?php
    $retrieveCategoriesQuery = "SELECT categoryId, name FROM ContentCamelCategories WHERE userID = '" . $_SESSION["userId"] . "'";
    $retrieveCategoriesResult = mysqli_query($mysqli, $retrieveCategoriesQuery);
    $categoryId;

    if (array_key_exists("category", $_POST)) {
        $existingCategoryFound = false;

        if ($_POST["category"] === "") {
            $categoryId = "NULL";
            return;
        }

        while ($row = mysqli_fetch_assoc($retrieveCategoriesResult)) {
            if ($row["name"] == $_POST["category"]) {
                $categoryId = "'" . $row["categoryId"] . "'";
                $existingCategoryFound = true;
            }
        }

        if (!$existingCategoryFound) {
            $categoryId = "'" . uniqid() . "'";
            $insertNewCategoryQuery = "INSERT INTO `ContentCamelCategories`(`categoryId`, `userId`, `name`) VALUES (" . $categoryId . ",'" . $_SESSION["userId"] . "','" . htmlentities($_POST["category"]) . "')";
            $insertNewCategoryResult = mysqli_query($mysqli, $insertNewCategoryQuery);
        }
    }
?>