<?php
    session_start();

    include "./functions.php";

    if (!isLogged()
        || !(isLoggedAs('pracownik') || isLoggedAs('admin')))
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
    <link rel="stylesheet" href="listaZadan.css">
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id="zadania">
        <?php
            $conn = newConn();

            $sql = "SELECT * FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id WHERE archiwizowane = false AND pracownik = '" . $_SESSION["login"] . "'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo "<div class='zadanie'>
                            <span>
                            <div class='info'>
                                <h3>" . $row["tytul"] . "</h3>
                                <p>" . $row["nazwa"] . "</p>
                            </div>
                            <div class='info'>
                                <p>" . $row["user"] . "</p>
                                <p>" . $row["data"] . "</p>
                            </div>
                            <p>" . ((!empty($row["pracownik"])) ? $row["pracownik"] : "brak") . "</p>
                            </span>
                            <div class='opis'>
                                <p>" . $row["opis"] . "</p>
                            </div>
                        </div>";
                }
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>