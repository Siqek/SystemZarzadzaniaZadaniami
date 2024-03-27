<?php
    session_start();

    include "./functions.php";

    if (!isLogged() && isset($_POST["zadanieID"]))
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
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id='content'>
        <a href="./listaZadan.php">powrót</a>
        <div id='zadanie'>
            <?php
                $conn = newConn();

                $sql = "SELECT * FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id WHERE `zadania`.id =" . $_POST["zadanieID"];
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0)
                {
                    $row = mysqli_fetch_assoc($result);

                    print_r($row);
                    #form do edycji jeżeli to ty utworzyleś to zadanie
                    #zmiana statusu jeżeli ty jesteś przypisany do zadania
                }
            ?>
        </div>
    </div>
</body>
</html>