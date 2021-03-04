<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php

    // declare global variables and set them to empty values
    $nickname = $email = $password = $telephone = "";
    // error variables
    $nicknameError = $emailError = $passwordError = $telephoneError = "";

    // checks for form validation
    $success = true;

    // if there is POST request, check form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // if name is empty, require it
        if (empty($_POST['nickname'])) {
            $nicknameError = "Nickname is required";
            $success = false;
        } else {
            // else check nickname and match with regex
            $nickname = checkInput($_POST['nickname']);

            if (!preg_match("/^[a-zA-Z0-9]{4,20}/", $nickname)) {
                $nicknameError = "Only digits and letters allowed(at least 4)";
                $success = false;
            }
        }

        // email validation
        if (empty($_POST['email'])) {
            $emailError = "Email is required";
            $success = false;
        } else {
            $email = checkInput($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailError = "Invalid email format";
                $success = false;
            }
        }

        if (empty($_POST['password'])) {
            $passwordError = "Password is required";
            $success = false;
        } else {
            $password = checkInput($_POST['password']);

            if (!preg_match("/^[a-zA-Z0-9]{6,20}$/", $password)) {
                $passwordError = "Password must be 6-20 letters";
                $success = false;
            }
        }

        if (empty($_POST['telephone'])) {
            $telephoneError = "Password is required";
            $success = false;
        } else {
            $telephone = checkInput($_POST['telephone']);

            if (!preg_match("/^[0-9]{10}$/", $telephone)) {
                $telephoneError = "Only digits are allowed";
                $success = false;
            }
        }

        // if form is valid, save information into the database
        if ($success) {
            /* database connection */

            // db config
            $dbserver = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "test";
            $dbport = 3306;

            try {
                // try to connect 
                $pdo = new PDO("mysql:host=$dbserver;port=$dbport;dbname=$dbname", $dbusername, $dbpassword);

                // set the error mode
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
                $pdo->exec("CREATE TABLE IF NOT EXISTS persons(
        personId INT NOT NULL AUTO_INCREMENT,
        nickname VARCHAR(40) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(80) NOT NULL,
        telephone VARCHAR(12) NOT NULL,
        PRIMARY KEY(personId)
    )");

                $statement = $pdo->prepare("INSERT INTO persons(nickname, email, password, telephone)
            VALUES (:nickname, :email, :password, :telephone)");

                $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

                $statement->bindParam(':nickname', $nickname);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':password', $encryptedPassword);
                $statement->bindParam(':telephone', $telephone);

                $statement->execute();

                // close the connection
                $pdo = null;
            } catch (PDOException $e) {
                // if there is any error, print it
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }


    // checks user input
    function checkInput($element)
    {
        $element = trim($element);
        // remove '\'
        $element = stripslashes($element);
        $element = htmlspecialchars($element);

        return $element;
    }

    // function is used to remember gender choice
    function selectedGender($field)
    {
        if ($field === $GLOBALS["gender"]) {
            echo "checked";
        }
    }
    ?>

    <h2>Enter a person information:</h2>

    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="error">* - required fields</div> <br>
        Nickname: <input type="text" name="nickname" value="<?php echo $nickname ?>" autocomplete="off" maxlength="20">
        <span class="error">* <?php echo $nicknameError; ?></span>
        <br> <br>

        Email: <input type="text" name="email" value="<?php echo $email ?>" autocomplete="off">
        <span class="error">* <?php echo $emailError; ?></span>
        <br> <br>

        Password: <input type="password" name="password" value="<?php echo $password ?>" autocomplete="off" maxlength="20">
        <span class="error">* <?php echo $passwordError; ?></span>
        <br> <br>

        Telephone: <input type="text" name="telephone" value="<?php echo $telephone ?>" autocomplete="off" maxlength="10">
        <span class="error">* <?php echo $telephoneError; ?></span>
        <br> <br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>