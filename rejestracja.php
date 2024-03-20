<?php
    session_start();

    include "./functions.php";

    if (isLogged())
    {
        navigateTo('./home.php');
    }

    if (isset($_POST["login"], $_POST["username"], $_POST["password"]) 
        && !empty($_POST["login"])
        && !empty($_POST["username"])
        && !empty($_POST["password"]))
    {
        $login = $_POST["login"];
        $pass = szyfrujPass($_POST["password"]);
        $username = $_POST["username"];

        $conn = newConn();

        $sql = "INSERT INTO `users` (login, password, username, upr) VALUES ('$login', '$pass', '$username', 1)";
        
        if (mysqli_query($conn, $sql))
        {
            setSessionUserVars($login, $username, 'user');
            navigateTo('./home.php');
        }
        else
        {
            echo "błąd";
        }

        mysqli_close($conn);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SZZ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="./rejestracja.php" method="POST">
        <input type="text" name="login" placeholder="login" maxlength="100">
        <input type="text" name="username" placeholder="nazwa użytkownika" maxlength="100">
        <input type="password" name="password" placeholder="hasło">
        <input type="submit" value="Utwórz konto">
    </form>
    <a href="./">zaloguj się</a>
</body>
</html>