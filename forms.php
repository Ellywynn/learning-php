<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handling PHP forms</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php

    // declare global variables
    // defaults
    $name = $email = $website = $comment = $gender = "";
    // errors
    $nameError = $emailError = $websiteError = $commentError = $genderError = "";

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

        // email validation
        if (empty($_POST['email'])) {
            $emailError = "Email is required";
        } else {
            $email = checkInput($_POST['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                $emailError = "Invalid email format";
        }

        // website validation
        if (empty($_POST['website'])) {
            $website = "";
        } else {
            $website = checkInput($_POST['website']);

            // dashes are allowed
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website))
                $websiteError = "Invalid website URL";
        }

        // comment validation
        if (empty($_POST['comment'])) {
            $comment = "";
        } else {
            $comment = checkInput($_POST['comment']);
        }

        // gender validation
        if (empty($_POST['gender'])) {
            $genderError = "Gender is required";
        } else {
            $gender = checkInput($_POST['gender']);
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

    <h1>Forms validation</h1>

    <!-- htmlspecialchars() is used to prevent malicious actions -->
    <!-- this action refers to itself !-->
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="error">* - required fields</div> <br>
        Name: <input type="text" name="name" value="<?php echo $name ?>">
        <span class="error">* <?php echo $nameError; ?></span>
        <br><br>
        E-mail:
        <input type="text" name="email" value="<?php echo $email ?>">
        <span class="error">* <?php echo $emailError; ?></span>
        <br><br>
        Website:
        <input type="text" name="website" value="<?php echo $website ?>">
        <span class="error"><?php echo $websiteError; ?></span>
        <br><br>
        Comment: <textarea name="comment" rows="5" cols="40"><?php echo $comment ?></textarea>
        <br><br>
        Gender:
        <input type="radio" name="gender" value="female" <?php selectedGender("female") ?>>Female
        <input type="radio" name="gender" value="male" <?php selectedGender("male") ?>>Male
        <input type="radio" name="gender" value="other" <?php selectedGender("other") ?>>Other
        <span class="error">* <?php echo $genderError; ?></span>
        <br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
</body>

</html>