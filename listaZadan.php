<?php
    session_start();

    include "./functions.php";

    if (!isLogged())
    {
        navigateTo('./');
    }

    if (isset($_POST["zadanieID"]))
    {
        $conn = newConn();

        if (isset($_POST["przypisz"]))
        {
            $sql = "UPDATE `zadania` SET `pracownik` = '" . $_SESSION["login"] . "' WHERE id = " . $_POST["zadanieID"];
            
            mysqli_query($conn, $sql);
        }
        else if (isset($_POST["archiwizuj"]))
        {
            $sql = "UPDATE `zadania` SET `archiwizowane` = true WHERE id = " . $_POST["zadanieID"];

            mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="listaZadan.css">
</head>
<body>
    <?php include "./menu.php"; ?>
    <div id="zadania">
        <?php
            $conn = newConn();

            $sql = "SELECT *, `zadania`.id as id_zadania FROM `zadania` JOIN `statusy` ON `zadania`.status = `statusy`.id WHERE archiwizowane = false";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo "<span class='elem'>
                            <div class='zadanie'>
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
                            </div>
                            <div class='tools'>";
                                if (empty($row["pracownik"]) && (isLoggedAs("pracownik") || isLoggedAs("admin")))
                                {
                                    echo "<form action='listaZadan.php' method='POST'>
                                        <input type='text' value='" . $row["id_zadania"] . "' name='zadanieID' hidden>
                                        <input type='submit' value='Przypisz się' name='przypisz'>
                                    </form>";
                                }
                                if (isLoggedAs('admin'))
                                {
                                    echo "<form action='listaZadan.php' method='POST'>
                                        <input type='text' value='" . $row["id_zadania"] . "' name='zadanieID' hidden>
                                        <input type='submit' value='Archiwizuj' name='archiwizuj'>
                                    </form>";
                                }
                    echo    "</div>
                        </span>";
                }
            }

            mysqli_close($conn);
        ?>
    </div>
</body>
</html>