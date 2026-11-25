<?php
    session_start();

    if (isset($_SESSION["isLoggedIn"])) {
        header("Location: ../my-posts/myposts.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Camel: Login</title>
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/accounts.css">
    <link rel="icon" href="../../images/logo/content-camel.png">
</head>
<body>
    <div class="accounts__form">
        <img alt="Content Camel Logo" src="../../images/logo/content-camel.png">
        <h1>Content Camel</h1>
        <h2>Login</h2>
        <form action="loginconfirmation.php" method="post">
            <label for="email">Email: </label>
            <input class="register__input" name="email" id="email" type="email" required /><br>
            <label for="password">Password: </label>
            <input class="register__input form__password-input" name="password" id="password" type="password" required /><br>
            <input class="form__submit" name="submit" type="submit" value="Login!" />
        </form>
        <a href="register.php">New here? Register an account now!</a>
    </div>
    <script src="./scripts/accounts.js"></script>
</body>
</html>