<?php
    session_start();

    include "./functions.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST["title"], $_POST["opis"])
        && !empty($_POST["title"])
        && !empty($_POST["opis"]))
    {
        $conn = newConn();
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
</head>
<body>
    <?php include './menu.php'; ?>
    <form action="./zadanieForm.php" method="POST">
        <input type="text" name="title" placeholder="tytuł" maxlength="100">
        <input type="text" name="opis" placeholder="opis">
        <input type="submit" value="Dodaj">
    </form>
</body>
</html>