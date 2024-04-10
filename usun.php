<?php
    session_start();

    include "./functions.php";
    include "./popup.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST["isSure"]))
    {
        $conn = newConn();

        $sql = "DELETE FROM `users` WHERE login = '" . $_SESSION["login"] . "'";

        if (mysqli_query($conn, $sql))
        {
            unsetSessionUserVars();
            setPopupVars("Sukces!", "Twoje konto zostało usunięte", "/index.php");
            navigateTo('./index.php');
        }
        else 
        {
            setPopupVars("Błąd!", "Nie można usunąć konta.");
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
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="usun.css">
    <link rel="stylesheet" href="popup.css">
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id='content'>
        <h2>NA PEWNO CHCESZ USUNĄĆ KONTO?</h2>
        <span>
            <button class='greenBtn'><a class='darkFont' href="./konto.php">NIE</a></button>
            <form action="./usun.php" method="POST">
                <button class='dangerButton' type="submit" name="isSure" value="true">TAK</button>
            </form>
        </span>
    </div>
    <?php popup(); ?>
</body>
</html>