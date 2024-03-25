<?php
    session_start();

    include "./functions.php";

    if (!isLogged())
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

            $sql = "SELECT * FROM `zadania` WHERE archiwizowane = false";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo "<div class='zadanie'>"
                            . $row["tytul"] . "<br>"
                            . $row["opis"] . "<br>"
                            . $row["user_login"] . "<br>" #user login zmienić na user!!
                            . (($row["pracownnik_login"] != NULL) ? $row["pracownik_login"] : "brak przydzielenia") . "<br>" #to samo!!
                        . "</div>";
                }
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>