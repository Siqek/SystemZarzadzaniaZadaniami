<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    if (!isLogged())
    {
        navigateTo('./');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SZZ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="popup.css">
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id='main'>
        <div>
            <?php popup(); ?>
        </div>
        HOME
    </div>
</body>
</html>