<?php 
    // Note from future Christa: hardcoded credentials were used for academic demonstration purposes, not to be done in prod environment
    $mysqli = mysqli_connect("localhost", "username", "password", "content_camel");
            
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $doesAccountWithEmailExistQuery = "SELECT CASE WHEN EXISTS (
            SELECT *
            FROM ContentCamelUsers
            WHERE email='" . $_GET["emailAddress"] . "' 
        )
        THEN 1
        ELSE 0
        END
    ";
    $doesAccountWithEmailExistResult = mysqli_query($mysqli, $doesAccountWithEmailExistQuery);
    echo mysqli_fetch_row($doesAccountWithEmailExistResult)[0];
?>