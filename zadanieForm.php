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
        $title = $_POST["title"];
        $opis = $_POST["opis"];
        $user = $_SESSION["login"];

        $conn = newConn();

        $sql = "INSERT INTO `zadania`(`tytul`, `opis`, `status`, `user`, `pracownik`, `data`, `archiwizowane`)
            VALUES ('$title','$opis', 1,'$user', NULL, CURRENT_DATE, false)";

        if (mysqli_query($conn, $sql))
        {
            
        }
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