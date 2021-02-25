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

    // declare global variables
    // defaults
    $name = $age = $surname = "";
    // errors
    $nameError = $surnameError = $ageError = "";

    // if there is POST request, check form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // if name is empty, require it
        if (empty($_POST['name'])) {
            $nameError = "Name is required";
        } else {
            // else check name and match with regex
            $name = checkInput($_POST['name']);

            if (!preg_match("/^[a-zA-Z]/", $name))
                $nameErr = "Only letters and white space allowed";
        }

        if (empty($_POST['surname'])) {
            $surnameError = "Surname is required";
        } else {
            $surname = checkInput($_POST['surname']);

            if (!preg_match("/^[a-zA-Z]/", $surname))
                $surnameError = "Only letters and white space allowed";
        }

        if (empty($_POST['age'])) {
            $ageError = "Age is required";
        } else {
            $age = checkInput($_POST['age']);

            if (!preg_match("/^[0-9]/", $age))
                $ageError = "Only numbers are allowed";
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
        Name: <input type="text" name="name" value="<?php echo $name ?>">
        <span class="error">* <?php echo $nameError; ?></span>
        <br> <br>

        Surname: <input type="text" name="surname" value="<?php echo $surname ?>">
        <span class="error">* <?php echo $surnameError; ?></span>
        <br> <br>

        Age: <input type="text" name="age" value="<?php echo $age ?>">
        <span class="error">* <?php echo $ageError; ?></span>
        <br> <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php

    /* database connection */

    // db config
    $dbserver = "localhost";
    $dbusername = "root";
    $dbpassword = "kitsuNYA6996";
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
            password VARCHAR(255) NOT NULL,
            telephone VARCHAR(12) NOT NULL,
            PRIMARY KEY(personId)
        )");

        //  $statement = $pdo->prepare("INSERT INTO persons(nickname, email, password, telephone)
        //  VALUES (:nickname, :email, :password, :telephone)");

        // $statement->bindParam(':nickname', $nickname);
        // $statement->bindParam(':email', $email);
        // $statement->bindParam(':password', $password);
        // $statement->bindParam(':telephone', $telephone);

        // $nickname = 'ellywynn';
        // $email = 'whatisyouandme@mail.ru';
        // $password = password_hash('abcd1234', PASSWORD_DEFAULT);
        // $telephone = '12341234';
        // $statement->execute();

        $statement = $pdo->prepare("SELECT password FROM persons WHERE nickname='ellywynn'");
        $statement->execute();

        $result = $statement->setFetchMode(PDO::FETCH_ASSOC);

        if (password_verify("abcd1234", $statement->fetchAll()[0]['password'])) {
            echo "<h2>PASSWORD VERIFIED</h2>";
        }


        // close the connection
        $pdo = null;
    } catch (PDOException $e) {
        // if there is any error, print it
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

</body>

</html>