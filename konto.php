<?php
    session_start();

    include "./functions.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST["newUsername"]))
    {
        $conn = newConn();

        $newUsername = $_POST["newUsername"];
        $login = $_SESSION["login"];

        $sql = "UPDATE `users` SET `username`='$newUsername' WHERE login = '$login'";

        if (mysqli_query($conn, $sql))
            $_SESSION["username"] = $newUsername;
        else
            echo mysqli_error($conn);

        unset($_POST["edit_username"]);
        unset($_POST["newUsername"]);

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
                    <input type="submit" name="edit_username" value="<?php echo (isset($_POST["edit_username"])) ? "Zapisz" : "Edytuj";?>">
                </form>
            </div>
        </div>
    </div>
</body>
</html>