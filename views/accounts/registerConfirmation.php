<?php 
    session_start();
    // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
    $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    $userExistsQuery = "SELECT email FROM ContentCamelUsers WHERE email = '" . $_POST["email"] . "'";
    $userExistsResult = mysqli_query($mysqli, $userExistsQuery);
    
    if ($userExistsResult -> num_rows == 0) {
        $userId = uniqid();
        $insertUserQuery = "INSERT INTO ContentCamelUsers(userId, email, forename, surname, password) VALUES ('" . $userId . "', '" . $_POST["email"] . "', '" . $_POST["forename"] . "', '" . $_POST["surname"] . "', '" . $_POST["password"] . "')";
        mysqli_query($mysqli, $insertUserQuery);
        echo "<script>alert('Account created successfully'); window.location = '../my-posts/myposts.php';</script>";
        $_SESSION["isLoggedIn"] = true;
        $_SESSION["userId"] = $userId;
    }
?>