<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>form validation</h1>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        Name: <input type="text" name="name">
        E-mail: <input type="text" name="email">
        Website: <input type="text" name="website">
        Comment: <textarea name="comment" rows="5" cols="40"></textarea>

        Gender:
        <input type="radio" name="gender" value="female">Female
        <input type="radio" name="gender" value="male">Male
        <input type="radio" name="gender" value="other">Other
    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = checkInput($_POST['name']);
        $email = checkInput($_POST['email']);
        $website = checkInput($_POST['website']);
        $comment = checkInput($_POST['comment']);

        $gender = checkInput($_POST['gender']);
    }


    function checkInput($element)
    {
        $element = trim($element);
        $element = stripslashes($element);
        $element = htmlspecialchars($element);

        return $element;
    }
    ?>
</body>

</html>