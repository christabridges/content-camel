<?php
    session_start();

    // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
    $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $retrieveUserQuery = "SELECT userId, email, password FROM ContentCamelUsers WHERE email = '" . $_POST["email"] . "'";
    $retrieveUserResult = mysqli_query($mysqli, $retrieveUserQuery);
    
    if ($retrieveUserResult -> num_rows == 0) {
        echo "<script>alert('Username or password is incorrect'); window.location = 'login.php';</script>";
    } else {
        $row = mysqli_fetch_assoc($retrieveUserResult);        
        
        if ($row["password"] !== $_POST["password"]) {
            echo "<script>alert('Username or password is incorrect'); window.location = 'login.php';</script>";
        } else {
            echo "<script>alert('Logged in successfully'); window.location = '../my-posts/myposts.php';</script>";
            $_SESSION["userId"] = $row["userId"];
            $_SESSION["isLoggedIn"] = true;
        }
    }
?>