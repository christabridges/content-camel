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
    <title>Content Camel: Register</title>
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/accounts.css">
    <link rel="icon" href="../../images/logo/content-camel.png">
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
</head>
<body>
    <div class="accounts__form">
        <img alt="Content Camel Logo" src="../../images/logo/content-camel.png">
        <h1>Content Camel</h1>
        <h2>Register</h2>
        <form action="registerconfirmation.php" method="post">
            <label for="forename">Forename: </label>
            <input class="register__input" name="forename" id="forename" type="text" required /><br>
            <label for="surname">Surname</label>
            <input class="register__input" name="surname" id="surname" type="text" required /><br>
            <label for="email">Email: </label>
            <input class="register__input" name="email" id="email" type="email" required /><br>
            <p class="error-label" id="emailExists">An account with this email already exists</p>
            <label for="password">Password: </label>
            <input class="register__input form__password-input" name="password" id="password" type="password" required /><br>
            <label for="confirmPassword">Confirm Password: </label>
            <input class="register__input form__password-input" name="confirmPassword" id="confirmPassword" type="password" required /><br>
            <p class="error-label" id="passwordMatch">Password fields must match</p>
            <input class="form__submit" name="submit" type="submit" value="Register!" />
        </form>
        <a href="login.php">Already have an account? Login here now!</a>
    </div>
    <script src="./scripts/accounts.js"></script>
    <script src="./scripts/checkPasswordsMatch.js"></script>
    <script src="./scripts/checkForExistingEmail.js"></script>
</body>
</html>