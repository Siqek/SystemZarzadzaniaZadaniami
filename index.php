<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    if (isset($_POST["login"], $_POST["password"]) 
        && !empty($_POST["login"])
        && !empty($_POST["password"]))
    {
        $login = $_POST["login"];
        $pass = szyfrujPass($_POST["password"]);

        $conn = newConn();

        $sql = "SELECT login, username, uprawnienia.nazwa as 'upr' FROM users JOIN uprawnienia ON uprawnienia.id = users.upr WHERE login = '$login' AND password = '$pass'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0)
        {
            $userInfo = mysqli_fetch_assoc($result);
            setSessionUserVars($userInfo["login"], $userInfo["username"], $userInfo["upr"]);

            setPopupVars("Sukces!", 
                "Witaj ponownie."
                . "\nWłaśnie się zalogowałeś <b>" . $_SESSION["username"] . "</b>.",
                "/home.php"
            );
        }
        else
        {
            setPopupVars("Pomyłka", "Upewnij się, czy login i hasło są poprawnie zapisane.");
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["log_btn"]))
    {
        unset($_POST["log_btn"]);
        setPopupVars("", "Wprowadź dane aby się zalogować");
    }

    if (isLogged())
    {
        navigateTo('./home.php');
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
            <h3>Zaloguj się na istniejące konto</h3>
        </div>
        <form id='form' action="./index.php" method="POST">
            <input type="text" name="login" placeholder="login" maxlength="100">
            <input type="password" name="password" placeholder="hasło">
            <div class='space'></div>
            <input type="submit" name='log_btn' value="Zaloguj się">
        </form>
    </div>
    <p>lub</p>
    <a href="./rejestracja.php">zarejestruj się</a>
    <?php popup(); ?>
</body>
</html>