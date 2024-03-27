<?php
    session_start();

    include "./functions.php";

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
            navigateTo('./index.php');
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
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id='content'>
        <h2>NA PEWNO CHCESZ USUNĄĆ KONTO?</h2>
        <span>
            <button><a href="./konto.php">NIE</a></button>
            <form action="./usun.php" method="POST">
                <input class='dangerButton' type="submit" name="isSure" value="TAK">
            </form>
        </span>
    </div>
</body>
</html>