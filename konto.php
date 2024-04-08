<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST['cancel_username']) || $_POST["newUsername"] == $_SESSION["username"])
    {
        unset($_POST["edit_username"]);
        unset($_POST["newUsername"]);
    }
    else if (isset($_POST["newUsername"]) && !empty($_POST["newUsername"]))
    {
        $conn = newConn();

        $newUsername = $_POST["newUsername"];
        $login = $_SESSION["login"];

        $sql = "UPDATE `users` SET `username`='$newUsername' WHERE login = '$login'";

        if (mysqli_query($conn, $sql))
        {
            $_SESSION["username"] = $newUsername;
            setPopupVars("Sukces!", "Zmieniono nazwę użytkownika.");
        }
        else
        {
            setPopupVars("Błąd!", 
                "Nie można zmienić nazwy użytkownika."
                . "\nSpróbuj ponownie później"
            );
        }

        unset($_POST["edit_username"]);
        unset($_POST["newUsername"]);

        mysqli_close($conn);
    }

    if (isset($_POST["cancel"]))
    {
        unset($_POST["edit_pass"]);
        unset($_POST["newPass"]);
    }
    else if (isset($_POST["newPassword"]) && !empty($_POST["newPassword"]))
    {
        $conn = newConn();

        $newPass = szyfrujPass($_POST["newPassword"]);
        $login = $_SESSION["login"];

        $sql = "UPDATE `users` SET `password`='$newPass' WHERE login = '$login'";

        if (mysqli_query($conn, $sql))
        {
            setPopupVars("Sukces!", "Hasło zostało zmienione.");
        }
        else
        {
            setPopupVars("Błąd!", 
                "Nie można zmienić hasła."
                . "\nSpróbuj ponownie później");
        }

        unset($_POST["edit_pass"]);
        unset($_POST["newPass"]);

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
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="konto.css">
    <link rel="stylesheet" href="popup.css">
</head>
<body>
    <?php include "./menu.php"; ?>
     
    <div id='content'>
        <div id='userInfo'>
            <div class='info'>
                <p>Login: </p>
                <p><?php echo $_SESSION["login"]; ?></p>
            </div>
            <div class='info'>
                <p>Nazwa konta: </p>
                <form action="./konto.php" method="POST">
                    <?php
                        if (isset($_POST["edit_username"]))
                        {
                            echo "<input type='text' value='" . $_SESSION["username"] . "' name='newUsername'>";
                        }
                        else
                        {
                            echo "<p>" . $_SESSION["username"] . "</p>";
                        }
                    ?>
                    <span>
                        <input type="submit" name="edit_username" value="<?php echo (isset($_POST["edit_username"])) ? "Zapisz" : "Edytuj";?>">
                        <?php
                            if (isset($_POST["edit_username"]))
                            {
                                echo "<input type='submit' value='Anuluj' name='cancel_username'>";
                            }
                        ?>
                    </span>
                </form>
            </div>
            <div class="info">
                <p>Hasło: </p>
                 <form action="./konto.php" method="POST">
                    <?php
                        if (isset($_POST["edit_pass"]))
                        {
                            echo "<input type='password' value='' name='newPassword'>";
                        }
                        else
                        {
                            echo "<p>****</p>";
                        }
                    ?>
                    <span>
                        <input type="submit" name="edit_pass" value="<?php echo (isset($_POST["edit_pass"])) ? "Zapisz" : "Zmień hasło";?>">
                        <?php
                            if (isset($_POST["edit_pass"]))
                            {
                                echo "<input type='submit' value='Anuluj' name='cancel'>";
                            }
                        ?>
                    </span>
                </form>
            </div>
            <div id='usun'>
                <form action="./usun.php" method='POST'>
                    <input id='dangerButton' type="submit" value="USUN KONTO">
                </form>
            </div>
        </div>
    </div>
    <?php popup(); ?>
</body>
</html>