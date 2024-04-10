<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

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
            setPopupVars("Błąd!", "Nie można utworzyć użytkownika.");
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["btn"]))
    {
        unset($_POST["btn"]);
        setPopupVars("", "Wprowadź dane aby utworzyć konto");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SZZ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="popup.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div id='form-container'>
        <div id='nag'>
            <h3>Utwórz nowe konto</h3>
        </div>
        <form id='form' action="./rejestracja.php" method="POST">
            <input type="text" name="login" placeholder="login" maxlength="100">
            <input type="text" name="username" placeholder="nazwa użytkownika" maxlength="100">
            <input type="password" name="password" placeholder="hasło">
            <div class='space'></div>
            <input type="submit" name='btn' value="Utwórz konto">
        </form>
    </div>
    <p>lub</p>
    <a href="./">zaloguj się na istniejące</a>
    <?php popup(); ?>
</body>
</html>